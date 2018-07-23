<?php
include_once "header.php";
include_once "db_con.php";
if(isset($_GET['id']) && !empty($_GET['id'])){

}else{
    $msg="Article Not Found";
}
$sql = "SELECT * FROM article where id=".$_GET['id'];
$result = $conn->query($sql);
if($result->num_rows>0){
    $row = $result->fetch_assoc();
}else{
    $msg="Article Not Found";
}
?>
    <style>
        .test-content{
            display: none;
        }
        #SubmitTest{
            display: none;
        }
    </style>
    <?php if(isset($msg) && !empty($msg)){
        ?>
        <div class="error">
            <?php echo $msg;?>
        </div>
        <?php
    die;} ?>
    <div class="row-diff">
        <h1 class="content-heading"><?php echo $row['article_title']?></h1>
        <hr>

        <br>

        <div>
            <?php echo $row['article_text']?>
        </div>

    </div>
<?php
include_once "footer.php";
?>