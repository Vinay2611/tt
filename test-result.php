<?php
error_reporting(E_ALL & ~E_NOTICE);
include_once "header.php";
include_once "db_con.php";
$error=false;
$msg='';

if(isset($_SESSION['current_test_id']) && isset($_POST['typed_text'])){
    
}else{
    $msg.="<br><p>You did not type the test at all. Please return to the previous page and take the test again.</p>";
    $error=true;
}
$sql = "SELECT * FROM test where id=".$_SESSION['current_test_id'];
$result = $conn->query($sql);
$state_array=array();
if($result->num_rows>0){
    $PageData = $result->fetch_assoc();
    $TestText=$PageData['test_text'];
    $TestID=$PageData['id'];
    $TestTime=intval($PageData['test_duration'])-intval($_POST['timer']);

}else{
    $msg.="<br><p>This test does not exist</p>";
    $error=true;
}
$error=false;
if(!isset($_POST['test_text'])){
    $msg.="<br><p>Test Text Required</p>";
    $error=true;
}
if(!isset($_POST['timer'])){
    $msg.="<br><p>Timer Value Required</p>";
    $error=true;
}
if(!isset($_POST['typed_text'])){
    $msg="<br><p>You did not type the test at all. Please return to the previous page and take the test again.</p>";
    $error=true;
}else{
    $TypedText=$_POST['typed_text'];
}

?>
    <style>
        .test-content{
            display: none;
        }
        #SubmitTest{
            display: none;
        }
        .well{
            padding: 4px 15px 0px 15px;
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
        }else{
            global $rsTestDetails;
            global $TestID; global $TestText;
            global $TypedText; global $TransactionID; global $TestDuration;global $TestTime;global $I;global $SourceArray;
            global $TestArray; global $wordsCorrect; global $wordsExtra; global $wordsIncorrect; global $wordsSkipped;
            global $wordsIncorrectTotal;global $wordsTotal,$charIncorrect,$wordExpected,$wordPrevious,$wordCurrent,$wordNext;
            global $x,$y,$SourceCounter,$TestCounter,$prevFlag,$Action,$CPMUncorrected;
            global $WPMUncorrected,$WPMCorrect,$Accuracy,$rs,$ResultID,$rsResults,$ResultsTotal;
            global $ResultsSlab1,$ResultsSlab2,$ResultsSlab3,$ResultsSlab4,$ResultsSlab5;


            function CheckTest($txtSource, $txtTyped)
            {
                global $SourceArray;
                global $TestArray; global $wordsCorrect; global $wordsExtra; global $wordsIncorrect; global $wordsSkipped;
                global $wordExpected,$wordPrevious,$wordCurrent,$wordNext;
                global $x,$y,$SourceCounter,$TestCounter,$prevFlag,$Action;

                $wordsExtra = 0;
                $wordsIncorrect = 0;
                $wordsSkipped = 0;
                $wordsCorrect = 0;
                $x = 0;
                $TestCounter = 0;
                $prevFlag = False;

                $txtSource.= " .";
                $txtTyped.=" .";
                $Action = array();

                $txtTyped = str_replace("  "," ",$txtTyped);
                $txtTyped = str_replace("   "," ",$txtTyped);

                $SourceArray = explode(" ", $txtSource);
                $TestArray = explode(" ", $txtTyped);
                $Action[$x] = 0;

                for ($SourceCounter = 0; $SourceCounter < count($SourceArray)-1; $SourceCounter++) {
                    if ($TestCounter >= count($TestArray)-1) {
                        break;
                    }
                    $y = $SourceCounter;
                    $wordExpected = $SourceArray[$SourceCounter];
                    $wordNext = "";
                    $wordCurrent = "";
                    $wordPrevious = "";
                    if (count($TestArray)-1 > $TestCounter) {
                        $wordNext = $TestArray[$TestCounter + 1];
                    }
                    if (count($TestArray)-1 >= $TestCounter) {
                        $wordCurrent = $TestArray[$TestCounter];
                    }
                    if ($TestCounter > 0) {
                        $wordPrevious = $TestArray[$TestCounter - 1];
                    }
                    CheckWord($wordExpected, $wordCurrent, $wordNext, $wordPrevious);
                    $TestCounter = $TestCounter + 1;
                    $x = $x + 1;
                }
                if ($wordsCorrect > 0) {
                    $wordsCorrect = $wordsCorrect - 1;
                }
            }

            function CheckWord($wordExpected, $wordCurrent, $wordNext, $wordPrevious)
            {
                global $wordsCorrect; global $wordsExtra; global $wordsIncorrect; global $wordsSkipped;
                global $wordExpected,$wordPrevious,$wordCurrent,$wordNext;
                global $x,$y,$TestCounter,$prevFlag,$Action;

                if ($wordExpected == $wordCurrent) {
                    if ($x > 0) {
                        if ($Action[$x - 1] == 0) {
                            $wordsIncorrect = $wordsIncorrect + 1;
                            $Action[$x - 1] = 1;
                        }
                    }
                    $Action[$x] = 1;
                    $wordsCorrect = $wordsCorrect + 1;
                } else if ($wordExpected == $wordNext) {
                    if ($x > 0) {
                        if ($Action[$x - 1] == 0) {
                            $wordsIncorrect = $wordsIncorrect + 1;
                            $Action[$x - 1] = 1;
                        }
                    }

                    $wordsExtra = $wordsExtra + 1;
                    $wordsCorrect = $wordsCorrect + 1;
                    $Action[$x] = 1;
                    $TestCounter = $TestCounter + 1;
                } else {
                    if ($x > 0) {
                        if ($Action[$x - 1] == 0) {
                            if ($wordExpected == $wordPrevious) {
                                $wordsSkipped = $wordsSkipped + 1;
                                $wordsCorrect = $wordsCorrect + 1;
                                $Action[$x - 1] = 1;
                                $Action[$x] = 1;
                                $TestCounter = $TestCounter - 1;
                                $y = $y - 1;
                                $prevFlag = true;
                            } else {
                                $wordsSkipped = $wordsSkipped + 1;
                                $Action[$x - 1] = 1;
                            }
                        }
                    }
                }
                $y=$y+1;
            }

            CheckTest($TestText,$TypedText);


            $wordsIncorrectTotal = $wordsIncorrect + $wordsExtra + $wordsSkipped;
            $wordsTotal = $wordsCorrect + $wordsIncorrect + $wordsExtra + $wordsSkipped;
            if($wordsTotal==0){
                $wordsTotal=1;
            }

            for($I=0;$I<strlen($TypedText." .");$I++){
                if(substr($TestText,$I+1,1)!==substr($TypedText,$I+1,1)){
                    $charIncorrect=$charIncorrect+1;
                }
            }
            define('AVGWORDLENGTH',19);

            $CPMUncorrected=round((strlen($TypedText." .")/$TestTime)*60);
            $WPMUncorrected = round(($wordsTotal/$TestTime)*60) + round((($wordsTotal/AVGWORDLENGTH)/$TestTime)*60);
            $WPMCorrect = round(($wordsCorrect/$TestTime)*60) + round((($wordsCorrect/AVGWORDLENGTH)/$TestTime)*60);
            $Accuracy = round(($wordsCorrect/$wordsTotal)*100);

        } ?>
        <h1 class="content-heading">TEST RESULTS</h1>
        <hr>
        <p>
            Lets see how you performed.
        </p>
       <div class="col-md-12 no-padding">
           <div class="col-md-6 no-padding">
               <div class="form-group">
                   <label class="control-label col-sm-8">Test Duration</label>
                   <div class="col-sm-4">
                       <?php echo $TestTime." secs";?>
                   </div>
               </div>
               <div class="form-group">
                   <label class="control-label col-sm-8">Uncorrected Characters/Min</label>
                   <div class="col-sm-4">
                       <?php echo $CPMUncorrected;?>
                   </div>
               </div>
               <div class="form-group">
                   <label class="control-label col-sm-8">Uncorrected Words/Min</label>
                   <div class="col-sm-4">
                       <?php echo $WPMUncorrected;?>
                   </div>
               </div>
               <div class="form-group">
                   <label class="control-label col-sm-8">Accuracy</label>
                   <div class="col-sm-4">
                       <?php echo $Accuracy."%";?>
                   </div>
               </div>
               <div class="form-group">
                   <label class="control-label col-sm-8">Corrected Total Net Words/Min</label>
                   <div class="col-sm-4">
                       <?php echo $WPMCorrect;?>
                   </div>
               </div>
           </div>
           <div class="col-md-6">
               <img src="images/smallcertificate.jpg">
           </div>
       </div>

        <div class="clearfix"></div>
        <br>
        <br>
        <p>Your overall performance with respect to other users on TypingCertification.com</p>

        <div class="col-md-12 well">
            <div class="row">
                <div class="form-group">
                    <?php
                    $sql = "SELECT COUNT(*) as total_record FROM results";
                    $result = $conn->query($sql);
                    if($result->num_rows>0){
                        $data = $result->fetch_assoc();
                        $total_record=$data['total_record'];
                    }else{
                        $total_record=1;
                    }
                    if($total_record==0){
                        $total_record=1;
                    }

                    $sql0 = "SELECT COUNT(*) as result FROM results where avg_CPWM<30";
                    $result0 = $conn->query($sql0);
                    if($result0->num_rows>0){
                        $data0 = $result0->fetch_assoc();
                        $width0=$data0['result'];
                    }else{
                        $width0=1;
                    }

                    $sql1 = "SELECT COUNT(*) as result FROM results where avg_CPWM>30 and avg_CPWM<40";
                    $result1 = $conn->query($sql1);
                    if($result1->num_rows>0){
                        $data1 = $result1->fetch_assoc();
                        $width1=$data1['result'];
                    }else{
                        $width1=1;
                    }

                    $sql2 = "SELECT COUNT(*) as result FROM results where avg_CPWM>40 and avg_CPWM<50";
                    $result2 = $conn->query($sql2);
                    if($result2->num_rows>0){
                        $data2 = $result2->fetch_assoc();
                        $width2=$data2['result'];
                    }else{
                        $width2=1;
                    }

                    $sql3 = "SELECT COUNT(*) as result FROM results where avg_CPWM>50 and avg_CPWM<60";
                    $result3 = $conn->query($sql3);
                    if($result3->num_rows>0){
                        $data3 = $result3->fetch_assoc();
                        $width3=$data3['result'];
                    }else{
                        $width3=1;
                    }

                    $sql4 = "SELECT COUNT(*) as result FROM results where avg_CPWM>60";
                    $result4 = $conn->query($sql4);
                    if($result4->num_rows>0){
                        $data4 = $result4->fetch_assoc();
                        $width4=$data4['result'];
                    }else{
                        $width4=1;
                    }
                    ?>
                    <label class="control-label col-sm-3"><30 WPM</label>
                    <div class="col-sm-9">
                       <div style="height: 20px;background: #000033; width: <?php echo isset($width0)?(($width0/$total_record)*100):'0' ?>%"></div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-3">30-40 WPM</label>
                <div class="col-sm-9">
                    <div style="height: 20px;background: #003366; width: <?php echo isset($width1)?(($width1/$total_record)*100):'0' ?>%"></div>
                </div>
            </div>
                </div>
            <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-3">40-50 WPM</label>
                <div class="col-sm-9">
                    <div style="height: 20px;background: #006699; width: <?php echo isset($width2)?(($width2/$total_record)*100):'0' ?>%"></div>
                </div>
            </div></div>
            <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-3">50-60 WPM</label>
                <div class="col-sm-9">
                    <div style="height: 20px;background: #0099CC; width: <?php echo isset($width3)?(($width3/$total_record)*100):'0' ?>%"></div>
                </div>
            </div></div>
            <div class="row" style="    background: #666666;    padding-top: 4px;">
            <div class="form-group" >
                <label class="control-label col-sm-3">>60 WPM</label>
                <div class="col-sm-9">
                    <div style="height: 20px;background: #00CCFF; width: <?php echo isset($width4)?(($width4/$total_record)*100):'0' ?>%"></div>
                </div>
            </div></div>
        </div>
        <div class="clearfix"></div>
        <br>
        <div align="center">
            <p>
                Practice again, take a certification test or tell your friends about this site.

            </p>
            <a href="" class="btn btn-default">Practice Again</a>
            <a href="register.php" class="btn btn-default">Take Certification Test</a>
            <a href="tell-friend.php" class="btn btn-default">Tell A Friend</a>
        </div>

    </div>
<?php
include_once "footer.php";
?>

