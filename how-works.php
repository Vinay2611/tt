<?php
include_once "header.php";
include_once "db_con.php";

$sql = "SELECT * FROM content_page WHERE id = '1'";
$result = $conn->query($sql);
$state_array=array();
if($result->num_rows>0){
    $PageData = $result->fetch_assoc();
}
?>

    <div>
        <h3 align="center"><b>Instant Online Typing Certificate</b></h3>
        <?php echo isset($PageData)? $PageData['page_text']:'No Data Found For This Page!';?>
    </div>
<?php
include_once "footer.php";
?>