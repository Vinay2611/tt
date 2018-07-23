<!doctype html>
<html lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Typing Certification Admin</title>
    <meta name="description" content="" />
    <meta name="Author" content="Dorin Grigoras [www.stepofweb.com]" />

    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />

    <!-- WEB FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />

    <!-- CORE CSS -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <!-- THEME CSS -->
    <link href="<?php echo base_url(); ?>assets/css/essentials.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />

</head>
<!--
    .boxed = boxed version
-->
<body>


<div class="padding-15">

    <div class="login-box">

        <!-- login form -->
        <?php
        $attributes = array('class' => 'sky-form boxed', 'id' => 'LoginForm');
        echo form_open('login/index',$attributes); ?>
            <header><i class="fa fa-users"></i> Sign In</header>

            <!--
            <div class="alert alert-danger noborder text-center weight-400 nomargin noradius">
                Invalid Email or Password!
            </div>

            <div class="alert alert-warning noborder text-center weight-400 nomargin noradius">
                Account Inactive!
            </div>

            <div class="alert alert-default noborder text-center weight-400 nomargin noradius">
                <strong>Too many failures!</strong> <br />
                Please wait: <span class="inlineCountdown" data-seconds="180"></span>
            </div>
            -->

            <fieldset>

                <section>
                    <label class="label">User Name</label>
                    <label class="input">
                        <i class="icon-append fa fa-envelope"></i>
                        <input type="text" name="username" id="Email">
                        <span class="tooltip tooltip-top-right">User Name</span>
                    </label>
                </section>

                <section>
                    <label class="label">Password</label>
                    <label class="input">
                        <i class="icon-append fa fa-lock"></i>
                        <input type="password" name="password" id="Password">
                        <b class="tooltip tooltip-top-right">Type your Password</b>
                    </label>
                    <label class="checkbox"><input type="checkbox" name="checkbox-inline" checked><i></i>Keep me logged in</label>
                </section>
                <?php
                if (isset($error_message) || validation_errors()) {
                    echo '<div class="alert alert-mini alert-danger margin-bottom-30" id="message-login">';
                    if(isset($error_message)){
                        echo "<p>".$error_message."</p>";
                    }
                    if(validation_errors()){
                        echo validation_errors();
                    }
                    echo "</div>";
                }
                ?>
            </fieldset>
            <footer>
                <button type="submit" class="btn btn-primary pull-right">Sign In</button>
                <!--<div class="forgot-password pull-left">
                    <a href="<?php /*echo base_url(); */?>register/index"><b>Need to Register?</b></a>
                </div>-->
            </footer>
        </form>
        <!-- /login form -->

        <hr />

    </div>

</div>

<!-- JAVASCRIPT FILES -->
<script type="text/javascript">var plugin_path = '<?php echo base_url(); ?>assets/plugins/';</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/app.js"></script>
</body>
</html>