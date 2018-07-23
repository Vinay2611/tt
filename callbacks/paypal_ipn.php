<?php
// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
// Set this to 0 once you go live or don't require logging.
define("DEBUG", 1);
// Set to 0 once you're ready to go live
define("USE_SANDBOX", 1);
define("LOG_FILE", "./ipn.log");
error_log(date('[Y-m-d H:i e] '). " ipn Called ". PHP_EOL, 3, LOG_FILE);
include_once "../db_con.php";
error_log(date('[Y-m-d H:i e] '). " ipn Called ". PHP_EOL, 3, LOG_FILE);
// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
    $keyval = explode ('=', $keyval);
    if (count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
    $get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
    if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
    } else {
        $value = urlencode($value);
    }
    $req .= "&$key=$value";
}
// Post IPN data back to PayPal to validate the IPN data is genuine
// Without this step anyone can fake IPN data
if(USE_SANDBOX == true) {
    $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
    $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}
$ch = curl_init($paypal_url);
if ($ch == FALSE) {
    return FALSE;
}
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
if(DEBUG == true) {
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}
// CONFIG: Optional proxy configuration
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
// Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below. Ensure the file is readable by the webserver.
// This is mandatory for some environments.
//$cert = __DIR__ . "./cacert.pem";
//curl_setopt($ch, CURLOPT_CAINFO, $cert);
$res = curl_exec($ch);
if (curl_errno($ch) != 0) // cURL error
{
    if(DEBUG == true) {
        error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
    }
    curl_close($ch);
    exit;
} else {
    // Log the entire HTTP response if debug is switched on.
    if(DEBUG == true) {
        error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
        error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
    }
    curl_close($ch);
}
// Inspect IPN validation result and act accordingly
// Split response headers and payload, a better way for strcmp
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));
if (strcmp ($res, "VERIFIED") == 0) {
    // check whether the payment_status is Completed
    // check that txn_id has not been previously processed
    // check that receiver_email is your PayPal email
    // check that payment_amount/payment_currency are correct
    // process payment and mark item as paid.
    // assign posted variables to local variables
   // $item_name = $_POST['item_name'];
  //  $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
   // $payment_amount = $_POST['mc_gross'];
  //  $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
  //  $receiver_email = $_POST['receiver_email'];
  //  $payer_email = $_POST['payer_email'];

    $transaction_idd=$_POST['custom'];
    error_log(date('[Y-m-d H:i e] '). " ipn Called: ".$txn_id." ".$transaction_idd. PHP_EOL, 3, LOG_FILE);
    error_log(date('[Y-m-d H:i e] '). " ipn custom_log ". $payment_status, 3, LOG_FILE);
    $sql = "SELECT * FROM transactions where id='$transaction_idd' LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows>0) {
        $row = $result->fetch_assoc();
        $credits_purchased=intval($row['credits_purchased']);
        $free_credits=intval($row['free_credits']);
        $certificates=intval($row['certificates']);
        $price=intval($row['price']);
        $quantity=intval($row['quantity']);
        $amount=intval($row['amount']);
        $member_email=$row['member_email'];
        $member_id=$row['member_id'];

        $add_credit=(intval($credits_purchased)+intval($free_credits))*$quantity;
        $add_certificates=intval($certificates)*$quantity;


        $ins_sql = "update member set  credits_remaining = credits_remaining + $add_credit, certificates_remaining=certificates_remaining + $add_certificates where id='$member_id'";
        $conn->query($ins_sql);

        $ins_sql2="update transactions set status='$payment_status' where id='$transaction_idd'";
        $conn->query($ins_sql2);
        $date=date('Y-m-d H:i:s');
        $narration = " Credits : $add_credit , Print Certificates Credit : $add_certificates Added in Price : $amount";
        $ins_sql3="insert into creditflow (member_id,`date`,credits,narration) values ('$member_id','$date','$add_credit','$narration')";
        $conn->query($ins_sql3);

        $p_string=$conn->escape_string($req);
        $ins_sql7="insert into postbacks (transaction_id,gateway,gateway_unique_id,date_received,postback_string,status,postback_data)  
        values ('$transaction_idd','Paypal','$txn_id','$date','$p_string','Payment processed successfully.','')";
        $conn->query($ins_sql7);

    }else{

    }

    if(DEBUG == true) {
        error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
    }
} else if (strcmp ($res, "INVALID") == 0) {
    // log for manual investigation
    // Add business logic here which deals with invalid IPN messages
    $payment_status = $_POST['payment_status'];
    // $payment_amount = $_POST['mc_gross'];
    //  $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    //  $receiver_email = $_POST['receiver_email'];
    //  $payer_email = $_POST['payer_email'];

    $transaction_idd=$_POST['custom'];
    $p_string=$conn->escape_string($req);
    $date=date('Y-m-d H:i:s');
    $ins_sql7="insert into postbacks (transaction_id,gateway,gateway_unique_id,date_received,postback_string,status,postback_data)  
        values ('$transaction_idd','Paypal','$txn_id','$date','$p_string','Processing.','')";
    $conn->query($ins_sql7);
    if(DEBUG == true) {
        error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
    }
}
?>