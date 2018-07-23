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



if(isset($_POST) && count($_POST)>0){
    if(!empty($_POST['fname']) && !empty($_POST['lname'])){
        $fname=$conn->escape_string($_POST['fname']);
        $lname=$conn->escape_string($_POST['lname']);
        $sql = "update member set first_name='$fname', last_name='$lname' where email='$member_email'";
        $result = $conn->query($sql);
        $msg="Profile Updated!";
    }else{
        $msg="Please Fill All Fields!";
    }
}

$sql = "SELECT * FROM member where email='$member_email'";
$result = $conn->query($sql);
$userData = $result->fetch_assoc();

?>
    <div>
        <p class="content-font">PROFILE MANAGEMENT</p>
        <hr>
        <?php if(isset($msg) && !empty($msg)){
            ?>
            <div class="c-red">
                <?php echo $msg;?>
            </div>
            <?php
        }?>

        <form method="post" action="">
            <div align="center">
                <table border="0" width="95" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr class="TableData">
                        <td width="50%" align="center">First Name</td>
                        <td width="50%" align="center">
                            <input type="text" name="fname" size="20" maxlength="100" value="<?php echo $userData['first_name'];?>">
                        </td>
                    </tr>
                    <tr class="TableData">
                        <td width="50%" align="center">Last Name</td>
                        <td width="50%" align="center">
                            <input type="text" name="lname" size="20" maxlength="100" value="<?php echo $userData['last_name'];?>">
                        </td>
                    </tr>
                    <tr class="TableData">
                        <td width="50%" align="center">Email Address</td>
                        <td width="50%" align="center">
                            <input type="text"  readonly size="20" maxlength="100" value="<?php echo $userData['email'];?>">
                        </td>
                    </tr>
                    <tr class="TableData">
                        <td width="50%" align="center">
                            <br>
                            <input type="submit" value="Update Profile" name="B1">
                        </td>
                        <td width="50%" align="center"> <br>
                            <input type="reset" name="B2" value="Undo changes">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

<?php
include_once "../footer.php";
?>