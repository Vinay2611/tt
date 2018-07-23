<?php
include_once "../header.php";
include_once "../db_con.php";
if(isset($_SESSION['is_logged_in']) && !empty($_SESSION['is_logged_in'])){
}else{
    header('Location: '.$base_url.'register.php');
    ob_end_flush();
    die();
}
$error=false;
if(isset($_POST['duration']) && !empty($_POST['duration'])){
    $duration=$_POST['duration'];
    $sql = "SELECT * FROM test where test_duration='$duration' order by RAND() LIMIT 1";
    $result = $conn->query($sql);
    $state_array=array();
    if($result->num_rows>0){
        $PageData = $result->fetch_assoc();
        $_SESSION['current_test_id']=$PageData['id'];
        $_SESSION['current_test_duration']=$PageData['test_duration'];
    }else{
        $_SESSION['current_test_id']='';
        $_SESSION['current_test_duration']='';
        $error=true;
        $msg="No Test found, Please Contact to Admin!";
    }
}else{
    $error=true;
    $msg="Please go back and select Test Duration.";
}

?>
<style>
    .test-content{
        display: none;
    }
    #SubmitTest{
        display: none;
    }
</style>

<div class="row-diff">
    <?php if(isset($error) && $error){
        ?>
        <div style="color:red">
            <?php echo $msg;?>
        </div>
        <?php
        die;
    }
    ?>
    <h1 class="content-heading">CERTIFICATION TEST</h1>
    <hr>
    <p>
        Please select the duration of the test. Government offices require a 5 minute test while other require a 3 minute test.

    </p>
    <br>
    <form action="test-result.php" method="post" id="SubmitTestForm">
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
            Time Remaining : <input type="text" name="timer" value="<?php echo $_SESSION['current_test_duration'];?>" id="timer" style="width: 50px;"  readonly> secs
            <br><br>
            <textarea style="width: 100%" rows="5" name="typed_text" id="typed-text"></textarea>
            <br><br>
            <input type="button" value="Start Test" id="StartTest" title="Click to Start Test">
            <input type="submit" value="Submit Test" id="SubmitTest" title="Click to Submit Test">
        </div>
    </form>
    <p >Click on the "Start Test" button below to start the test. You will be typing in the white box below. Click on the "Done" button when you are finished. Good luck!
    </p>
</div>
<?php
include_once "../footer.php";
?>

<script>
    $(function () {
        $t_val=<?php echo $_SESSION['current_test_duration'];?>;
        $("#timer").val($t_val);
        $("#StartTest").click(function () {
            var InitialTimer=$t_val;
            $(".test-content").show();
            $("#StartTest").hide();
            $("#SubmitTest").show();
            $timeout=($t_val*1000)+1;

            var startTimer=setInterval(function () {
                InitialTimer-=1;
                $("#timer").val(InitialTimer);
            },1000);
            setTimeout(function () {
                clearInterval(startTimer);
                $("#SubmitTestForm").submit();
            },$timeout);
        });
    });
</script>
