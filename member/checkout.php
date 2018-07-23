<?php
include_once "../config.php";
include_once "../header.php";
include_once "../db_con.php";
if(isset($_SESSION['is_logged_in']) && !empty($_SESSION['is_logged_in'])){
}else{
    header('Location: '.$base_url.'register.php');
    ob_end_flush();
    die();
}
$transaction_id="";
$quantity="";
$amount="";
if(isset($_POST) && isset($_POST['ProductID']) && !empty($_POST['ProductID']) && !empty($_POST['Quantity'])){
    $email=$_SESSION['is_logged_email'];
    $sql = "SELECT * FROM member where email='$email' LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows>0) {
        $userData = $result->fetch_assoc();
        $user_id = $userData['id'];
    }
    $product_id=$_POST['ProductID'];
    $quantity=intval($_POST['Quantity']);
    $sql = "SELECT * FROM product where id='$product_id' LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $transaction_date=date('Y-m-d H:i:s');
        $member_email=$_SESSION['is_logged_email'];
        $credits_purchased=$row['test_credits'];
        $free_credits=$row['free_credits'];
        $certificates=$row['printed_certificates'];
        $price=$row['price'];
        $amount=floatval($price)*$quantity;
        $status='Pending';

        if(!empty($amount) && !empty($quantity)){

        }else{
            $msg="Invalid Transaction!";
            echo $msg;
            die;
        }
       $sql = "insert into transactions (transaction_date,member_id,member_email,credits_purchased,free_credits,certificates,price,quantity,amount,status)
                              values ('$transaction_date','$user_id','$member_email','$credits_purchased','$free_credits','$certificates','$price','$quantity','$amount','$status')";
        if($conn->query($sql)){
            $transaction_id=$conn->insert_id;
            $_SESSION['order'] = array('quantity' => $quantity,'email' => $member_email);
        }
    }else{
        $msg="Please Select Product And Quantit11y";
    }
}else{
    $msg="Please Select Product And Quantity";
}

if(!empty($transaction_id) && !empty($amount) && !empty($quantity)){

}else{
    $msg="Invalid Transaction!";
    echo $msg;
    die;
}

?>
    <style>
        .product-box{
            width: 50%;
            border: 2px solid #cccccc;
            text-align: center;
        }
    </style>
    <div class="row-diff"> <?php if(isset($msg) && !empty($msg)){
            ?>
            <div class="error">
                <?php echo $msg;?>
            </div>
            <?php
            die;} ?>
        <h1 class="content-heading">SECURE CHECKOUT</h1>
        <hr>
        <br>
        <div>
            This is the Test Credit Purchase Secure Checkout screen. Here you will see the details of the order for the final time before you proceed to the payment gateway. Please review the details of your order carefully and then choose your mode of payment
            <br><br>
            <span class="c-red">Important: </span>At the last step of your PayPal checkout process when your payment is through, don't refresh or click the back button for at least 10 seconds or you may be charged twice. You need not to close PayPal window at all. After 10 seconds PayPal will automatically redirect you to our site.
        </div>
        <br>

        <div class="col-md-12">
            <p align="center">
               <b> <?php echo $row['product_title'];?></b>
            </p>
            <div class="row">
                <div class="form-group">
                    <label class="control-label no-padding col-sm-6 member-label">Total Test Credits</label>
                    <div class="col-sm-6 no-padding">
                       <?php echo (intval($row['test_credits'])+intval($row['free_credits']))*intval($quantity);?> credit(s)
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="control-label no-padding col-sm-6 member-label">Printed Certificates</label>
                    <div class="col-sm-6 no-padding">
                        <?php echo intval($row['printed_certificates'])*intval($quantity);?> certificate(s)
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="control-label no-padding col-sm-6 member-label">Total Amount</label>
                    <div class="col-sm-6 no-padding">
                        $ <?php echo $amount;?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-sm-6">
                        <form method="post" action="<?php echo PAYPALSERVER ?>">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="business" value="<?php echo MERCHANTIDPAYPAL ?>">
                        <input type="hidden" name="item_name" value="TypingCertification.com: <?php echo $row['product_title'];?>">
                        <input type="hidden" name="quantity" value=" <?php echo isset($quantity)?$quantity:''?>">
                        <input type="hidden" name="amount" value=" <?php echo isset($amount)?$amount:'' ;?>">
                        <input type="hidden" name="custom" value="<?php echo isset($transaction_id)?$transaction_id:'' ;?>">
                        <input type="hidden" name="currency_code" value="IN">
                        <input type="hidden" name="no_shipping" value="0">
                        <input type="hidden" name="no_note" value="1">
                        <input type="hidden" name="return_url" value="<?php echo BASEURL?>thankyou.php">
                        <input type="hidden" name="return" value="<?php echo BASEURL?>thankyou.php">
                        <input type="hidden" name="cancel_return" value="<?php echo BASEURL;?>">
                        <input type="hidden" name="notify_url" value="<?php echo BASEURL;?>callbacks/paypal_ipn.php">
                        <input type="submit" value="Purchase through PayPal">
                        </form>
                        </div>
                    <div class="col-sm-6 no-padding">
                        <a href="http://sl1.xyz/tyiping" onclick="window.open(this.href,  null, 'height=447, width=800, toolbar=0, location=0, status=0, scrollbars=1, resizable=1'); return false;"><strong>Credit Card Payment</strong></a>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <br>
        <p align="ceneter" class="c-red"><i>
                All our payments are processed over secure network connections. So you can rest assured that your payment details will be 100% SAFE from prying eyes.</i>
        </p>
        <br><br>
        <hr>
    </div>
<?php
include_once "../footer.php";
?>