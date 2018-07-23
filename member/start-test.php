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

$credits_remaining=$userData['credits_remaining'];
$certificates_remaining=$userData['certificates_remaining'];
if(empty($credits_remaining) || $credits_remaining==0 || $credits_remaining=='' || $credits_remaining<1){
    $msg="<br><p>Your Credit Balance is 0! please Purchase Test Credits</p>";
    $error=true;
}

?>
<style>
    .test-content{
        display: none;
    }

</style>

<div class="row-diff">
    <h1 class="content-heading">CERTIFICATION TEST</h1>
    <?php if(isset($error) && $error){
        ?>
        <div style="color:red">
            <?php echo $msg;?>
        </div>
        <?php
        die;
    }?>
    <hr>
    <p>
        Please select the duration of the test. Government offices require a 5 minute test while other require a 3 minute test.
    </p>
    <br>
    <form action="take-test.php" method="post" id="SubmitTestForm">
        <?php if(isset($PageData['test_text'])){
            ?>
            <div class="test-content">
                <?php echo $PageData['test_text'];?>
                <input type="hidden" name="test_text" value="<?php echo $PageData['test_text'];?>">
            </div>
            <?php
        }?>
        <br>
        <div align="center">
            Duration : <select id="" name="duration">
                <option value="300">5 Minutes </option>
                <option value="180">3 Minutes </option>
            </select>
            <br><br>
            <input type="submit" value="Submit Test" id="SubmitTest" title="Click to Submit Test">
        </div>
    </form>

    </p>
</div>
<?php
include_once "../footer.php";
?>

