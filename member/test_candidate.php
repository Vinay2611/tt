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
$error=false;
$member_name=$userData['first_name']." ".$userData['last_name'];;

$credits_remaining=$userData['credits_remaining'];
$logged_id=$userData['id'];
$certificates_remaining=$userData['certificates_remaining'];
if(empty($credits_remaining) || $credits_remaining==0 || $credits_remaining=='' || $credits_remaining<1){
    $msg="<br><p>Your Credit Balance is only $credits_remaining ! please Purchase Test Credits to add Test Candidate</p>";
    $error=true;
}else{
    if ($_POST && !empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["confirm_password"])) {
        $fname = $conn->escape_string($_POST["fname"]);
        $credits=    $conn->escape_string($_POST["credit"]);
        if(empty($credits)){
            $credits=1;
        }
        if($credits<=$credits_remaining){
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
                    $account_type='Employee';
                    $sql = "INSERT INTO member (corporate_member_id,first_name,last_name,email,password,account_type,created_on,credits_remaining,certificates_remaining) VALUES ('$logged_id','$fname', '$lname','$email','$e_pwd','$account_type','$created_on','$credits','0')";
                    if ($conn->query($sql) === TRUE) {
                        $last_id = $conn->insert_id;
                        $date=date('Y-m-d H:i:s');
                        $narration="Assigned to ".$email;
                        $sql2 = "INSERT INTO creditflow (member_id,`date`,credits,narration) VALUES ('$logged_id','$date','$credits','$narration')";
                        $conn->query($sql2);
                        $new_credits=intval($credits_remaining)-$credits;
                        $sql2 = "update member set credits_remaining='$new_credits' where email='$member_email'";
                        $result2 = $conn->query($sql2);



                        $to = $email;
                        $from = "";
                        $subject = "Welcome to Typing Certification !";
                        $body="               
                            <p>Dear $fname $lname</p>
                            <p>Thank you for registering with our site. Your username is $email and your password is : $password
                            <br>
                            Please visit TypingCertification.com and login using your username and password to take the test. You have enough credits for $credits certification test(s). And you can take as many practice tests as you like.
                            <br>
                           If we can be of any further help to you, please don't hesitate to let us know!<br>
                            $member_name <br>
                            $member_email                            
                            <br>                
                            </p>";

                        if(send_mail( $to, $from, $subject, $body )){
                            $msg="Email Sent Successfully";
                        }else{
                            $msg="Failed to sent mail!";
                        }

                        $msg="Test Candidate Added Successfully";


                    } else {
                        $msg="Please Try Again!";
                        $error=true;
                    }
                }
            }
            unset($_POST);
        }else{
            $error=true;
            $msg="You are not have sufficient Credits!";

        }
    }
}


?>
    <style>
        .product-box{
            width: 50%;
            border: 2px solid #cccccc;
            text-align: center;
        }
    </style>
    <div class="row-diff">
        <h1 class="content-heading"><?php echo isset($_REQUEST['id'])?'UPDATE ':''?>TEST CANDIDATE</h1>
        <hr>
        <?php if(isset($error) && $error){
            ?>
            <div style="color:red">
                <?php echo $msg;?>
            </div>
            <?php
            die;
        }?>

        <p>
            Please complete the fields below and the candidate will be emailed instructions on how to take the test. You will both get a copy of the results.

        </p>
        <br>

        <form class="form-horizontal" action="" method="post">
            <fieldset>
                <?php if($msg){
                    ?>
                    <div class="c-red"><?php echo $msg;?></div>
                <?php
                }?>
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
                <br>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Credits to Add	</label>
                    <div class="col-md-4">
                        <input id="textinput" name="credit" type="number" placeholder="Credits to Add" value="1" class="form-control input-md">
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
                        <button type="submit" id="singlebutton" name="singlebutton" class="btn btn-primary">Add Candidate</button>
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
include_once "../footer.php";
?>