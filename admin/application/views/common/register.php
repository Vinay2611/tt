<!doctype html>
<html lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Alka Admin</title>
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
        <!--
        <div class="alert alert-danger">Complete all fields!</div>
        -->
        <!-- registration form -->
            <?php
            $attributes = array('class' => 'sky-form boxed', 'id' => 'RegisterForm');
            echo form_open('register/index',$attributes); ?>
            <header><i class="fa fa-users"></i> Create Account <small class="note bold">IT'S FREE</small></header>
            <fieldset>
                <label class="input">
                    <i class="icon-append fa fa-envelope"></i>
                    <input type="text" name="email" placeholder="Email address">
                    <b class="tooltip tooltip-bottom-right">Needed to verify your account</b>
                </label>

                <label class="input">
                    <i class="icon-append fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Password">
                    <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                </label>

                <label class="input">
                    <i class="icon-append fa fa-lock"></i>
                    <input type="password" name="conf_password" placeholder="Confirm password">
                    <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                </label>
            </fieldset>

            <fieldset>
                <div class="row">
                    <div class="col-md-6">
                        <label class="input">
                            <input type="text" name="fname" placeholder="First name">
                        </label>
                    </div>
                    <div class="col col-md-6">
                        <label class="input">
                            <input type="text" name="lname" placeholder="Last name">
                        </label>
                    </div>
                </div>

                <label class="select">
                    <select>
                        <option value="0" name="gender" selected disabled>Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Other</option>
                    </select>
                    <i></i>
                </label>

                <div class="margin-top20">
                    <label class="checkbox nomargin"><input class="checked-agree" type="checkbox" name="checkbox"><i></i>I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms of Service</a></label>
                    <label class="checkbox nomargin"><input type="checkbox" name="checkbox"><i></i>I want to receive news and  special offers</label>
                </div>

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
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Create Account</button>
            </footer>

        </form>
        <!-- /registration form -->

        <hr />

        <div class="text-center">
           <a href="<?php echo base_url(); ?>login/index">Back</a>
        </div>
    </div>

</div>


<!-- JAVASCRIPT FILES -->
<script type="text/javascript">var plugin_path = '<?php echo base_url(); ?>assets/plugins/';</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/app.js"></script>

<!-- PAGE LEVEL SCRIPTS -->
<script type="text/javascript">

    /**
     Checkbox on "I agree" modal Clicked!
     **/
    jQuery("#terms-agree").click(function(){
        jQuery('#termsModal').modal('toggle');

        // Check Terms and Conditions checkbox if not already checked!
        if(!jQuery("#checked-agree").checked) {
            jQuery("input.checked-agree").prop('checked', true);
        }

    });
</script>

</body>
</html>