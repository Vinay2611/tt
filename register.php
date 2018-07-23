<?php
include_once "header.php";
include_once "db_con.php";
$error=false;
if ($_POST && !empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["confirm_password"])) {
    $fname = $conn->escape_string($_POST["fname"]);
    $lname = $conn->escape_string($_POST["lname"]);
    $email = $conn->escape_string($_POST["email"]);
    $password = $_POST["password"];
    $re_password = $_POST["confirm_password"];
    if($password!==$re_password){
        $error=true;
        $msg='Password and Confirm password Not Matched!';
    }else{
        $e_pwd = password_hash($password, PASSWORD_DEFAULT, array('cost' =>10));
        $sql = "SELECT * FROM member where email= '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $msg="This Email is already Registered!";
            $error=true;
        }else{
            $created_on=date('Y-m-d H:i;s');
            $account_type='Personal';
            $sql = "INSERT INTO member (first_name,last_name,email,password,account_type,created_on,credits_remaining,certificates_remaining) VALUES ('$fname', '$lname','$email','$e_pwd','$account_type','$created_on','0','0')";
            if ($conn->query($sql) === TRUE) {
                $last_id = $conn->insert_id;
                $date=date('Y-m-d H:i:s');
                $sql2 = "INSERT INTO creditflow (member_id,`date`,credits,narration) VALUES ('$last_id','$date','0','Account Opened')";
                $conn->query($sql2);
                $_SESSION['is_logged_in']=true;
                $_SESSION['is_logged_email']=$email;
                $_SESSION['is_logged_type']='Personal';

                $to = $email;
                $from = "";
                $subject = "Welcome to Typing Certification !";
                $body="               
                <p>Dear $fname $lname</p>
                <p>Thank you for registering with our site. Your username will be your email address and your password is : $password
                <br>
                You can use the site TypingCertification.com to take as many practice tests as you want.
                <br>
                If we can be of any further help to you, please don't hesitate to let us know!
                Ian Hewitt<br>
                Number 1963<br>
                14781 Memorial Dr.<br>
                Houston, TX 77079<br>
                USA<br>                
                </p>";

                if(send_mail( $to, $from, $subject, $body )){
                    $msg="Email Sent Successfully";
                }else{
                    $msg="Failed to sent mail!";
                }

                header('Location: '.$base_url.'member/index.php');
                exit;
                ob_end_flush();
                die();
            } else {
                $msg="Please Try Again!";
                $error=true;
            }
        }
    }
    unset($_POST);
}
?>

    <div>
        <legend>MEMBER REGISTRATION</legend>

        <?php if(isset($error) && $error){
            ?>
            <div style="color:red">
                <?php echo $msg;?>
            </div>
            <?php

        }
        ?>

        <p>Please register using the form below. If you have already registered,
            please using the login form on the left side to login.
        </p>
        Corporate users, who wish to use our site to test employees, can  <a href="corporate-register.php">Register Here.</a>
        <hr>
        <form class="form-horizontal" action="" method="post">
            <fieldset>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">First Name	</label>
                    <div class="col-md-4">
                        <input id="textinput" name="fname" type="text" placeholder="First Name" class="form-control input-md">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Last Name	</label>
                    <div class="col-md-4">
                        <input id="textinput" name="lname" type="text" placeholder="Last Name" class="form-control input-md">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Email Address	</label>
                    <div class="col-md-4">
                        <input id="textinput" name="email" type="email" placeholder="Email Address" class="form-control input-md">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Password	</label>
                    <div class="col-md-4">
                        <input id="textinput" name="password" type="password" placeholder="Password" class="form-control input-md">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Confirm Password	</label>
                    <div class="col-md-4">
                        <input id="textinput" name="confirm_password" type="password" placeholder="Confirm Password" class="form-control input-md">

                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="singlebutton"></label>
                    <div class="col-md-4">
                        <button type="submit" id="singlebutton" name="singlebutton" class="btn btn-primary">Register</button>
                    </div>
                </div>
                <h1 style="font-size: 15;">
                    Note: We will never rent or sell your name or e-mail address to anyone.
                    Email address is used for tracking purposes only.
                </h1>

            </fieldset>
        </form>
    </div>
<?php
include_once "footer.php";
?>