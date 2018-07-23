<?php

include_once "header.php";

?>
<html>

<head><title>Member registration</title></head>
<body>
<div>
    <form><form>
            <div align="center"><b>Member Registration</b></b></div>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd">
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Remember me</label>
            </div>
            <button type="submit" class="btn btn-default">Login</button>
            <button type="submit" class="btn btn-default">Forgot Password</button>
            <div align="center">
                <img src="images/bestchoice.png" height="100" width="100";>
            </div>
        </form>

    </form>
</div>

</body>
</html>
<?php
include_once "footer.php";
?>