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
$credit_balance=$userData['credits_remaining'];
$member_id=$userData['id'];
$member_name=$userData['first_name']." ".$userData['last_name'];
if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
    $rid=$_REQUEST['id'];
    $sql2 = "SELECT * FROM results where member_id='$member_id' and id='$rid' order by `test_date` desc";
    $result2 = $conn->query($sql2);
    if($result2->num_rows>0){

    }else{
        echo "No Result Found!";die;
    }
}else{
    echo "No Result Found!";die;
}

$test_result = $result2->fetch_assoc();
?>
    <div style="margin-left: -20px;">
        <h1 class="content-heading">ORDER PRINTED CERTIFICATE</h1>
        <hr>
        <div class="row">
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Test Date</label>
                <div class="col-md-4">
                    <?php echo $test_result['test_date'];?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Name</label>
                <div class="col-md-4">
                    <?php echo $member_name;?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Uncorrected CPM</label>
                <div class="col-md-4">
                    <?php echo $test_result['UCPM'];?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Uncorrected WPM</label>
                <div class="col-md-4">
                    <?php echo $test_result['UWPM'];?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Accuracy</label>
                <div class="col-md-4">
                    <?php echo $test_result['accuracy'];?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Avg. Corrected WPM</label>
                <div class="col-md-4">
                    <?php echo $test_result['avg_CWPM'];?>
                </div>
            </div>
        </div>
        <br>
        <div align="center"><a href="<?php echo $base_url;?>/member/confirm-print.php?id=<?php echo $rid;?>" class="btn btn-sm btn-default">Confirm Print Order</a></div>
        <div class="clearfix"></div>
        <hr>
    </div>

<?php
include_once "../footer.php";
?>