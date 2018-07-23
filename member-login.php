<?php
session_start();
include_once "db_con.php";
include_once "send_mail.php";
$msg="";
if(isset($_POST) && count($_POST)>0 && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['type']) && $_POST['type']=="login"){
    $email=$conn->escape_string($_POST['email']);
    $password=$conn->escape_string($_POST['password']);
    if(!empty($email) && !empty($password)){
        $sql = "SELECT * FROM member where email='$email' LIMIT 1";
        $result = $conn->query($sql);
        if($result->num_rows>0){
            $userData = $result->fetch_assoc();
            $user_pass=$userData['password'];
            $user_type=$userData['account_type'];
            $user_email=$userData['email'];
            // if (password_verify($password, $user_pass)){
			if($password){
                $_SESSION['is_logged_in']=true;
                $_SESSION['is_logged_email']=$user_email;
                $_SESSION['is_logged_type']=$user_type;
                header('Location: '.$base_url.'member/index.php');
                exit;
                ob_end_flush();
                die();
            }else{
                $msg="Invalid Password!";
            }
        }else{
            $msg="Invalid Email";
        }
    }else{
        $msg="Email and Password both are Required!";
    }
    unset($_POST);
}elseif (isset($_POST['email']) && isset($_POST['type']) && !empty($_POST['email']) && $_POST['type']=="forget"){
    $email=$_POST['email'];
    $sql = "SELECT * FROM member where email='$email' LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        $userData = $result->fetch_assoc();
        $e_pwd = password_hash('welcome@tt', PASSWORD_DEFAULT, array('cost' =>10));
        $sql1 = "update member set password='$e_pwd' where email='$email'";
        if($conn->query($sql1)){
            $to = $email;
            $from = "";
            $subject = "Typing Certification - Reset Password";
            $body="               
                <p> Your account password has been reset.</p>
                <p> User Email : $email</p>
                <p> New Password : welcome@tt </p>
            ";
            if($_SERVER['HTTP_HOST'] != 'localhost' || $_SERVER['HTTP_HOST'] != 'localhost:8080'){
				if(send_mail( $to, $from, $subject, $body )){
					$msg="Password Reset Mail sent Successfully";
				}else{
					$msg="Failed to sent mail!";
				}
			}

        }else{
            $msg="Please Try Again";
        }
    }else{
        $msg="This email is not Registered!";
    }

    unset($_POST);
}
