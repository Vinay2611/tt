<?php
include_once "header.php";
include_once "db_con.php";
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
$password=$userData['password'];
$error=false;
if(isset($_POST) && count($_POST)>0){
    if(isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])){
        $old_password=$_POST['old_password'];
        $new_password=$_POST['new_password'];
        $confirm_password=$_POST['confirm_password'];
        if($new_password!==$confirm_password){
            $msg="Password did not matched!";
            $error=true;
        }else{
            if(password_verify($old_password,$password)){
                $e_pwd = password_hash($new_password, PASSWORD_DEFAULT, array('cost' =>10));
                $sql = "update member set password='$e_pwd' where email='$member_email'";
                $result = $conn->query($sql);
                $msg="Password Changed Successfully!";
                $error=true;
            }else{
                $msg="Wrong Old Password!";
                $error=true;
            }
        }
    } else{
        $msg="Please Fill All Required Fileds";
        $error=true;
    }
}

?>
    <div style="margin-left: -20px;">
        <h1 class="content-heading">CHANGE PASSWORD</h1>
        <hr>
        <?php if(isset($msg) && !empty($msg)){
            ?>
                <div class="c-red"><?php echo $msg;?></div>
            <?php
        }?>
        <form method="POST" action="" name="frmPasswordChange">
            <div align="center">
                <center>
                    <table border="0" width="95%" cellspacing="0" cellpadding="0">
                        <tbody><tr class="TableData">
                            <td width="50%" align="center">Old Password</td>
                            <td width="50%" align="center"><input type="password" required name="old_password" size="20" maxlength="15"></td>
                        </tr>
                        <tr class="TableData">
                            <td width="50%" align="center">New Password</td>
                            <td width="50%" align="center"><input type="password" name="new_password" required size="20" maxlength="15"></td>
                        </tr>
                        <tr class="TableData">
                            <td width="50%" align="center">Confirm Password</td>
                            <td width="50%" align="center"><input type="password" name="confirm_password" required size="20" maxlength="15"></td>
                        </tr>
                        <tr class="TableData">
                            <td width="100%" colspan="2" align="center">&nbsp;</td>
                        </tr>
                        <tr class="TableData">
                            <td width="100%" colspan="2" align="center"><input type="submit" value="Change Password" name="B1"></td>
                        </tr>
                        </tbody></table>
                </center>
            </div>
        </form>
    </div>

<?php
include_once "footer.php";
?>