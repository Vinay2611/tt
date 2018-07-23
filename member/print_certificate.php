<?php
ob_start();
include_once "../member-login.php";
include_once "../db_con.php";
if(isset($_SESSION['is_logged_in']) && !empty($_SESSION['is_logged_in'])){
}else{
    header('Location: '.$base_url.'register.php');
    ob_end_flush();
    die();
}

$member_email=$_SESSION['is_logged_email'];
$sql = "SELECT * FROM member where email='$member_email'";
$result = $conn->query($sql);
$userData = $result->fetch_assoc();
$member_id=$userData['id'];
$user_name=$userData['first_name']." ".$userData['last_name'];
if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
    $result_id=$_REQUEST['id'];
    $sql2 = "SELECT * FROM results where member_id='$member_id' and id='$result_id'order by `test_date` desc";
    $result = $conn->query($sql2);
    if($result->num_rows>0){
        $resultData = $result->fetch_assoc();
        $date=$resultData['test_date'];
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $date);
        $cert_year= $date->format("Y");
        $cert_day= $date->format("d");
        $cert_month= $date->format("F");
        $image_path2=$base_url.'images/certificates/certificate_'.$result_id.'.jpg';
        $image_path='../images/certificates/certificate_'.$result_id.'.jpg';
        $dt="The $cert_day th day of $cert_month in the year $cert_year";
        $cwpmm=$resultData['avg_CWPM'];
        $to = $member_email;
        $from = "";
        $subject = "The TypingCertification.Com Typing Certificate you requested !";
        $body="               
                <p>Dear $user_name</p>
                <p>As you requested, we have generated your Typing Certificate and have provided the link below where you may view it online:
                $image_path2
                <br>
                Please note that your certificate will be available online for the next.<br>                
                72 hours at which time it will be deleted and the link will no longer work - given that, please print and/or save the image as soon as possible.<br>
                <br>
                However it will also be available online in your account for 3 months<br>
                <br>
                Test Date : $dt
                <br>
                Average corrected words per minute score = $cwpmm words per minute
                <br>
                If we can be of any further help to you, please don't hesitate to let us know!<br>
                webmaster@TypingCertification.com<br>
                Ian Hewitt<br>
                Number 1963<br>
                14781 Memorial Dr.<br>
                Houston, TX 77079<br>
                USA<br>                
                </p>";

        if(send_mail( $to, $from, $subject, $body )){
         //   $msg="Email Sent Successfully";
        }else{
         //   $msg="Failed to sent mail!";
        }


        //Set the Content Type
        header('Content-type: image/gif');
       // $user_name="phjgj gh j";
        $font1  = 30;
        $width1 = imagefontwidth($font1) * strlen($user_name);
        $durationn=($resultData['test_duration']/60).":00";

        $jpg_image = imagecreatefromgif('default-certificate.gif');

        $white = imagecolorallocate($jpg_image, 0, 0, 0);

        $font_path = 'arial.ttf';


        imagettftext($jpg_image, $font1, 0, ((750/2)-($width1/2)), 180, $white, $font_path, $user_name);
        imagettftext($jpg_image, 12, 0, 220, 270, $white, $font_path, $resultData['UCPM']);
        imagettftext($jpg_image, 12, 0, 297, 290, $white, $font_path, $resultData['UWPM']);
        imagettftext($jpg_image, 12, 0, 247, 310, $white, $font_path, $resultData['accuracy']."%");
        imagettftext($jpg_image, 12, 0, 134, 330, $white, $font_path, $resultData['avg_CWPM']);
        imagettftext($jpg_image, 12, 0, 500, 330, $white, $font_path, $durationn);
        imagettftext($jpg_image, 16, 0, 250, 374, $white, $font_path, $dt);
        imagegif($jpg_image);
      //  $image_path='../images/certificates/certificate_'.$result_id.'.jpg';
        imagejpeg($jpg_image, $image_path);
        imagedestroy($jpg_image);
    }else{
        echo "Result Not Found!";
        die;
    }
}else{
    echo "Invalid Request";
    die;
}
?>



