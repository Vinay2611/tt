<?php
include_once "header.php";
include_once "db_con.php";

$sql = "SELECT * FROM test where test_duration='30' order by RAND() LIMIT 1";
$result = $conn->query($sql);
$state_array=array();
if($result->num_rows>0){
    $PageData = $result->fetch_assoc();
    $_SESSION['current_test_id']=$PageData['id'];
}else{
    $_SESSION['current_test_id']='';
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
        <h1 class="content-heading">PRACTICE TEST</h1>
        <hr>
        <p>
            Click on the "Start Test" button below to start the test. You will be typing in the white box below. Click on the "Done" button when you are finished. Good luck!
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
                Time Remaining : <input type="text" name="timer" value="30" id="timer" style="width: 50px;"  readonly> secs
                <br><br>
                <textarea style="width: 100%" rows="5" name="typed_text" id="typed-text"></textarea>
                <br><br>
                <input type="button" value="Start Test" id="StartTest" title="Click to Start Test">
                <input type="submit" value="Submit Test" id="SubmitTest" title="Click to Submit Test">
            </div>
        </form>
    </div>
<?php
include_once "footer.php";
?>

<script>
    $(function () {
       $("#timer").val(30);
       $("#StartTest").click(function () {
           var InitialTimer=30;
           $(".test-content").show();
           $("#StartTest").hide();
           $("#SubmitTest").show();

           var startTimer=setInterval(function () {
               InitialTimer-=1;
               $("#timer").val(InitialTimer);
           },1000);
          setTimeout(function () {
              clearInterval(startTimer);
              $("#SubmitTestForm").submit();
          },31000);
       });
    });
</script>
