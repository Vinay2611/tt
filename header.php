<?php
ob_start();
include_once "member-login.php";
/*define('BASEURL','http://dsvinfosolutions.com/typingtest/');
$base_url="http://dsvinfosolutions.com/typingtest/";*/

// define('BASEURL','http://dsvinfosolutions.com/typingtest/');
// $base_url="http://dsvinfosolutions.com/typingtest/";

define('BASEURL','http://localhost/tt/');
$base_url="http://localhost/tt/";
?>
<html>
<head>
    <title>Typing Certificate, TypingCertification.com</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <!-- InstanceBeginEditable name="head" -->
    <META NAME="name" CONTENT="Official Free Typing Tests and Instant Official Job Typing Certificates">
    <meta name="google-site-verification" content="rBSzIFOSdbwvXp7Jx9whe9pHeG5v9FKeUL0snoZxO2A" />
    <meta name="google-site-verification" content="e6kL7kJHSNLVMu9I_c_jQLSRRrtmAQU0yW87pFESaD4" />
    <!-- InstanceEndEditable -->
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-25341921-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>

    <link rel="canonical" href="http://www.typingcertification.com/" />

    <meta name="description" content="Do You Need An Instant, Reliable, Accurate, and Low-Cost online typing certificate, then please email at webmaster@TypingCertification.com."/>


    <link rel="stylesheet" href="<?php echo $base_url;?>css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $base_url;?>css/style2.css">

    <script   src="<?php echo $base_url;?>js/jquery-1.12.js"></script>
    <script   src="<?php echo $base_url;?>js/bootstrap.js"></script>
</head>
<body>
<style>
    .no-padding{
        padding: 0px;
    }
    .error{
        color: red;
        padding: 0px 18px;
        text-align: center;
    }
</style>
    <div class="container no-padding">
        <div class="header">
            <img src="<?php echo $base_url;?>images/header.jpg">
            <div class="header-row">
                <ul class="top-menus">
                    <li><a href="<?php echo $base_url;?>index.php">Home</a></li>
                    <li><a href="<?php echo $base_url;?>about-us.php">About Us </a></li>
                    <li><a href="<?php echo $base_url;?>how-works.php">How it works</a></li>
                    <li><a href="<?php echo $base_url;?>register.php">Register</a></li>
                    <li><a href="<?php echo $base_url;?>corporate-register.php">Corporate</a></li>
                    <li><a href="<?php echo $base_url;?>faqs.php">FAQ </a></li>
                    <li><a href="<?php echo $base_url;?>articles.php">Article </a></li>
                    <li><a href="<?php echo $base_url;?>privacy-policy.php">Privacy Policy </a></li>
                    <li><a href="<?php echo $base_url;?>contact-us.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container no-padding" style="display: flex;">
        <div class="col-md-3 col-sm-3 col-xs-3 col-1 member-box no-padding">
            <?php if(isset($_SESSION['is_logged_in']) && isset($_SESSION['is_logged_in']) && ($_SESSION['is_logged_type']=='Personal' || $_SESSION['is_logged_type']=='Employee')){

                ?>
                <br>
                <div class="col-sm-12 side-menu1">
                    <a href="<?php echo $base_url;?>member/profile.php">Profile Management</a><br>
                    <a href="<?php echo $base_url;?>practice-test.php">Practice Test</a><br>
                    <a href="<?php echo $base_url;?>member/start-test.php">Certification Test</a><br>
                <?php if($_SESSION['is_logged_type']=='Personal'){
                    ?>
                    <a href="<?php echo $base_url;?>member/secure-purchase.php">Purchase Test Credits</a><br>
                    <a href="<?php echo $base_url;?>member/credit-records.php">Test Credit Records</a><br>
                    <?php
                    }?>
                    <a href="<?php echo $base_url;?>member/test-results.php">Test Results</a><br>
                    <a href="<?php echo $base_url;?>change-password.php">Change Password</a><br>
                    <a href="<?php echo $base_url;?>logout.php">Logout</a><br><br>
                </div>
            <?php
            }else if(isset($_SESSION['is_logged_in']) && isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_type']=='Corporate') {
            ?>
                <br>
                <div class="col-sm-12 side-menu1">
                    <a href="<?php echo $base_url;?>member/profile.php">Profile Management</a><br>
                    <a href="<?php echo $base_url;?>member/secure-purchase.php">Purchase Test Credits</a><br>
                    <a href="<?php echo $base_url;?>member/credit-records.php">Test Credit Records</a><br>
                    <a href="<?php echo $base_url;?>member/test_candidate.php">Test Candidate</a><br>
                    <a href="<?php echo $base_url;?>member/manage_candidate.php">Manage Candidate</a><br>
                    <a href="<?php echo $base_url;?>change-password.php">Change Password</a><br>
                    <a href="<?php echo $base_url;?>logout.php">Logout</a><br><br>
                </div>
                <?php
            }else{  ?>
                <form class="form-horizontal" method="post" action="">
                    <br>
                    <div align="center" class="member-label"><b>MEMBER LOGIN</b></br></div>
                    <?php if(isset($msg) && !empty($msg)){
                        ?>
                    <div class="error">
                        <?php echo $msg;?>
                    </div>
                    <?php
                    } ?>
                    <div class="form-group">
                        <label for="email" class="control-label no-padding col-sm-6 member-label">Email</label>
                        <div class="col-sm-6 no-padding">
                            <input required name='email' type="email" class="" id="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label no-padding col-sm-6 member-label">Password</label>
                        <div class="col-sm-6 no-padding">
                            <input name="password" type="password" class="" id="pwd">
                        </div>
                    </div>
                    <div align="center">
                        <button type="submit" name="type" value="login" class="">Login</button><br>
                        <button type="submit" name="type" value="forget" class="">Forgot Password</button>
                    </div>
                </form>
                <div align="center">

                    <img src="<?php echo $base_url;?>images/bestchoice.png" height="65" width="65">
                </div>
            <?php
            }?>

            <br>  <br>
            <img src="<?php echo $base_url;?>images/TypingMan.jpg" style="max-width: 100%" alt="typing man">
            <br>  <br>
            <div class="col-sm-12 side-menu">
                <a href="<?php echo $base_url;?>tell-friend.php">Tell a Friend</a>
                <a href="<?php echo $base_url;?>related-links.php">Related Links</a>
                <a href="<?php echo $base_url;?>improve-speed.php">Improve your Speed</a><br><br>
            </div>

            <div align="center"><img src="<?php echo $base_url;?>images/securesite.jpg" alt="secure site"> </div><br><br>
        </div>
        <div class="col-md-9 col-sm-9 no-padding">
            <div class="">
                <div class="pricing">
                    <div class="styled"></div>
                    <a href="<?php echo $base_url;?>member/start-test.php">Take test for <span style="color: red;">$7.85</span></a> &nbsp;&nbsp;&nbsp;
                    <!-- <a href="<?php echo $base_url;?>practice-test.php">Practice for <span style="color: red;">free</span></a> -->
                    <a href="<?php echo $base_url;?>practicetest.php">Practice for <span style="color: red;">free</span></a>
                </div>
            </div>
            <div class="page-contents">