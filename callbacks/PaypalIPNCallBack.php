<?php
include_once "../db_con.php";

$data=json_encode($_REQUEST);
file_put_contents("test.txt","Hello World. Testing!".$data);
$sql = "INSERT INTO postbacks (postback_data) values('$data')";
if ($conn->query($sql) === TRUE) {

}
?>