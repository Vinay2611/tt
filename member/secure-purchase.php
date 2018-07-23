<?php
include_once "../header.php";
include_once "../db_con.php";
if(isset($_SESSION['is_logged_in']) && !empty($_SESSION['is_logged_in'])){
}else{
    header('Location: '.$base_url.'register.php');
    ob_end_flush();
    die();
}
?>
<style>
    .product-box{
        width: 50%;
        border: 2px solid #cccccc;
        text-align: center;
    }
</style>
    <div class="row-diff">
        <h1 class="content-heading">SECURE ORDER PAGE</h1>
        <hr>
        <p>
            Practice tests are free on our site. But in order to take certification tests, you would need to purchase Test Credits. Each Test Credit will allow you to take 1 (One) Certification Test.
        </p>
        <br>
        <label>Printed Certificates</label>
        <p>
            Besides our online certificates, we also provide you with <span class="c-red">Printed Certificates.</span> Once you have taken the test(s), the system will give you an option to order a printed certificate with the results of any of the tests that you have taken. You have <span class="c-red">complete control </span>over which test results get printed on your Printed Certificate.
        </p>

        <br>
        <label>Instructions</label>
        <p>
            Select the appropriate product that you would like to purchase. Each product has a preset number of Test Credits and/or Printed Certificates associated with it. Simply click on the "Buy Now" button below the product details to purchase it.
        </p>

        <br>

        <div class="">
                <tbody>
                <?php
                $sql = "SELECT * FROM product";
                $result = $conn->query($sql);
                if($result->num_rows>0){
                    $i=1;
                    while($row = $result->fetch_assoc()) {
                 ?>
                        <div class="pull-left product-box">
                            <form method="post" action="<?php echo !empty($row['upgrade_to'])?'secure-upgrade.php':'checkout.php'?>">
                                <input type="hidden" name="ProductID" value="<?php echo $row['id']; ?>">
                                <div style="background-color:#DDDDDD; border-bottom:2px solid #CCCCCC"><strong><?php echo $row['product_title'];?></strong></div>
                                <br>
                                <?php echo $row['test_credits'];?> Test Credit(s)
                                <br><?php echo $row['free_credits'];?> Free Test Credit(s)
                                <br><?php echo $row['printed_certificates'];?> Printed Certificate(s)
                                <br><strong>for $ <?php echo $row['price'];?> only.</strong><br>
                                <br>Quantity: <input type="text" name="Quantity" value="1" style="width:1.5em; text-align:center"><br>
                                <input type="submit" value="Buy Now">
                            </form>
                        </div>
                 <?php
                        if($i%2==0){
                     ?>
                            <div class="clearfix"></div>
                            <?php
                        }
                        $i++; }  }else{
                }
                ?>

        </div>
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