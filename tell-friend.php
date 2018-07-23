<?php
include_once "header.php";
include_once "db_con.php";
include_once "send_mail.php";

if(isset($_POST) && count($_POST)>0){
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['friend_name']) && !empty($_POST['friend_email'])){
        $to = $_POST['friend_email'];
        $from = "";
        $subject = "Check it Out!";
        $body="               
                <p> Your Friend ".$_POST['name']." feels you will enjoy this useful site!!.</p>
                <p> <a href='http://www.typingcertification.com/'>http://www.typingcertification.com/</a> Please visit for your free typing test</p>                
            ";
        if(send_mail( $to, $from, $subject, $body )){
            $msg="Email Sent Successfully";
        }else{
            $msg="Failed to sent mail!";
        }
    }else{
        $msg="Please Fill All Fields!";
    }
}

?>

    <div>
        <form class="form-horizontal" method="post" action="">
            <fieldset>

                <!-- Form Name -->
                <legend>TELL A FRIEND</legend>

                <?php if(isset($msg) && !empty($msg)){
                    ?>
                    <div class="c-red">
                        <?php echo $msg;?>
                    </div>
                <?php
                }?>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Your Name	</label>
                    <div class="col-md-4">
                        <input id="textinput" name="name" required type="text" placeholder="Your Name" class="form-control input-md">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Your Email Address	</label>
                    <div class="col-md-4">
                        <input id="textinput" name="email" required type="text" placeholder="Your Email Address" class="form-control input-md">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Friend's Name	</label>
                    <div class="col-md-4">
                        <input id="textinput" name="friend_name" required type="text" placeholder="Friend's Name" class="form-control input-md">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Friend's Email Address	</label>
                    <div class="col-md-4">
                        <input id="textinput" name="friend_email" type="email" required placeholder="Friend's Email Address" class="form-control input-md">

                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="singlebutton"></label>
                    <div class="col-md-4">
                        <button id="singlebutton" type="submit" name="singlebutton" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </fieldset>
        </form>
    </div>
<?php
include_once "footer.php";
?>