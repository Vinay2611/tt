<?php

include_once "../header.php";
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
$credits=$userData['credits_remaining'];
?>
    <div>
        <strong>Welcome to the TypingCertification.Com Member's Area.</strong>
        <br><br>

<p>        Currently logged in as: <?php echo $_SESSION['is_logged_email'];?>
        <br><br>
        Current credit level: <?php echo $credits;?> credit(s)</p>
        <br><br>
        Use links on the left of screen to continue.



    </div>

<?php
include_once "../footer.php";
?>