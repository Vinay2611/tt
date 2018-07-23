<?php

include_once "header.php";
include_once "send_mail.php";

if(isset($_POST) && count($_POST)>0){
    if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['email']) && !empty($_POST['message'])){
        $to = "";
        $from = "";
        $subject = "New Contact Mail!";
        $body="               
               <p> <b>New Contact Query Received!</b></p>
                <p> Name: ".$_POST['fname']." ".$_POST['lname']."</p>
                <p> Email: ".$_POST['email']."</p>
                <p> Message: ".$_POST['message']."</p>                
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

    <legend>CONTACT FORM</legend>
<?php if(isset($msg) && !empty($msg)){
    ?>
    <div class="c-red">
        <?php echo $msg;?>
    </div>
    <?php
}?>

    <form class="form-horizontal" action="" method="post">
        <fieldset>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">First Name*	</label>
                <div class="col-md-4">
                    <input id="textinput"  name="fname" type="text" placeholder="First Name" required class="form-control input-md">

                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Last Name*	</label>
                <div class="col-md-4">
                    <input id="textinput" name="lname" type="text" placeholder="Last Name" required class="form-control input-md">

                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Email*	</label>
                <div class="col-md-4">
                    <input id="textinput" name="email" type="email" placeholder="Email" required class="form-control input-md">

                </div>
            </div>
            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textarea">Message*</label>
                <div class="col-md-4">
                    <textarea style="height:150px; width:300px" class="form-control" id="textarea" name="message" required></textarea>
                </div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="singlebutton"></label>
                <div class="col-md-4">
                    <input type="submit" id="singlebutton" name="submit" name="singlebutton" class="btn btn-primary"/>
                </div>
            </div>
            <h1 style="font-size: 15px;">
                Note: We will never rent or sell your name or e-mail address to anyone.
                Email address is used for tracking purposes only.
            </h1>

        </fieldset>
    </form>

<?php
include_once "footer.php";
?>