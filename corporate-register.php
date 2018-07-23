<?php
include_once "header.php";
include_once "db_con.php";

$sql = "SELECT * FROM content_page WHERE id = '3'";
$result = $conn->query($sql);
$state_array=array();
if($result->num_rows>0){
    $PageData = $result->fetch_assoc();
}


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
            $account_type='Corporate';
            $sql = "INSERT INTO member (first_name,last_name,email,password,account_type,created_on,credits_remaining,certificates_remaining) VALUES ('$fname', '$lname','$email','$e_pwd','$account_type','$created_on','0','0')";
            if ($conn->query($sql) === TRUE) {
                $last_id = $conn->insert_id;
                $date=date('Y-m-d H:i:s');
                $sql2 = "INSERT INTO creditflow (member_id,`date`,credits,narration) VALUES ('$last_id','$date','0','Account Opened')";
                $conn->query($sql2);
                $_SESSION['is_logged_in']=true;
                $_SESSION['is_logged_email']=$email;
                $_SESSION['is_logged_type']='Personal';
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
        <?php echo isset($PageData)? $PageData['page_text']:'No Data Found For This Page!';?>

    <br>
        <?php if(isset($error) && $error){
            ?>
            <div style="color:red">
                <?php echo $msg;?>
                <br>
            </div>
            <?php
        }
        ?>
        <form class="form-horizontal" action="" method="post">
            <fieldset>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">First Name	</label>
                    <div class="col-md-4">
                        <input id="textinput" name="fname" type="text" placeholder="Full Name" class="form-control input-md">

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
                        <input id="textinput" name="email" type="text" placeholder="Email Address" class="form-control input-md">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Password	</label>
                    <div class="col-md-4">
                        <input  size="25" id="textinput" name="password" type="password" placeholder="Password" class="form-control input-md">

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