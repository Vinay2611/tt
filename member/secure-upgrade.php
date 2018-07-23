<?php
include_once "../header.php";
include_once "../db_con.php";
if(isset($_SESSION['is_logged_in']) && !empty($_SESSION['is_logged_in'])){
}else{
    header('Location: '.$base_url.'register.php');
    ob_end_flush();
    die();
}

if(isset($_POST) && isset($_POST['ProductID']) && !empty($_POST['ProductID']) && !empty($_POST['Quantity'])){
    $product_id=$_POST['ProductID'];
    $quantity=$_POST['Quantity'];
    $sql = "SELECT * FROM product where id='$product_id' LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        $row = $result->fetch_assoc();
    }else{
        $msg="Please Select Product And Quantit11y";
    }
}else{
    $msg="Please Select Product And Quantity";
}

?>
    <style>
        .product-box{
            width: 50%;
            border: 2px solid #cccccc;
            text-align: center;
        }
    </style>
    <div class="row-diff"> <?php if(isset($msg) && !empty($msg)){
            ?>
            <div class="error">
                <?php echo $msg;?>
            </div>
            <?php
        die;} ?>
        <h1 class="content-heading">SECURE ORDER UPGRADE PAGE</h1>
        <hr>
        <br>
        <div>
            <?php echo $row['upgrade_text'];?>
        </div>
        <br>
        <div class="pull-left">
            <form method="post" action="checkout.php" name="frmProduct2" >
                <input type="hidden" name="ProductID" value="<?php echo $row['upgrade_to'];?>">
                <input type="hidden" name="Quantity" value="<?php echo $quantity;?>">
                <input type="submit" value="Upgrade Me!">
            </form>
        </div>
        <div class="pull-right">
            <form method="post" action="checkout.php" name="frmProduct2" >
                <input type="hidden" name="ProductID" value="<?php echo $row['id'];?>">
                <input type="hidden" name="Quantity" value="<?php echo $quantity;?>">
                <input type="submit" value="No Thanks, continue...">
            </form>
        </div>
        <div class="clearfix"></div>
        <br>
        <p align="ceneter" class="c-red"><i>
                All our payments are processed over secure network connections. So you can rest assured that your payment details will be 100% SAFE from prying eyes.</i>
        </p>
        <br><br>
        <p>
            After completing your transaction, you may return to TypingCertification.Com and after logging in you may take your tests at any time that's convenient for you. You can check your credit balance at any time by clicking on "Test Credit Records" in the menu on the left. Use your credits for any test at any time by signing in with your username and password.
        </p>
    </div>
<?php
include_once "../footer.php";
?>