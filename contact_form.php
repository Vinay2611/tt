<?php

include_once "header.php";

?>
    <html>
    <head>
        <title>Contact_Form</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <!-- InstanceBeginEditable name="head" -->
        <META NAME="name" CONTENT="Official Free Typing Tests and Instant Official Job Typing Certificates">
        <meta name="google-site-verification" content="rBSzIFOSdbwvXp7Jx9whe9pHeG5v9FKeUL0snoZxO2A" />
        <meta name="google-site-verification" content="e6kL7kJHSNLVMu9I_c_jQLSRRrtmAQU0yW87pFESaD4" />
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <style>textarea {
                resize: none;
            }</style>
    </head>
    <legend>CONTACT FORM</legend>

    <hr>
    <form class="form-horizontal" action="contact-us.php" method="post">
        <fieldset>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">First Name*	</label>
                <div class="col-md-4">
                    <input id="textinput" name="fname" type="text" placeholder="First Name" required class="form-control input-md">

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
                    <textarea style="height:150px; width:300px"class="form-control" id="textarea" name="textarea" required>Message</textarea>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <h1 style="font-size: 15;">Are you a human being?</h1>
                <div class="g-recaptcha" data-sitekey="6LdfSgcUAAAAAASWvV2iJ75VQ8cM1jPGCg6ZDVvE"></div>

                <div class="col-md-4">

                </div>
            </div>


            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="singlebutton"></label>
                <div class="col-md-4">
                    <input type="submit" id="singlebutton" name="submit" name="singlebutton" class="btn btn-primary"/>
                </div>
            </div>
            <h1 style="font-size: 15;">
                Note: We will never rent or sell your name or e-mail address to anyone.
                Email address is used for tracking purposes only.
            </h1>

        </fieldset>
    </form>
    </html>

<?php
include_once "footer.php";
?>