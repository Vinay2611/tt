<?php
include_once "../header.php";
include_once "../db_con.php";
if(isset($_SESSION['is_logged_in']) && !empty($_SESSION['is_logged_in'])){
}else{
    header('Location: '.$base_url.'register.php');
    ob_end_flush();
    die();
}
$member_email=$_SESSION['is_logged_email'];
$sql = "SELECT * FROM member where email='$member_email'";
$result = $conn->query($sql);
$userData = $result->fetch_assoc();
$credit_balance=$userData['credits_remaining'];

if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
    $member_id=$_REQUEST['id'];
}else{
    $member_id=$userData['id'];
}
$sql2 = "SELECT * FROM results where member_id='$member_id' order by `test_date` desc";
$result = $conn->query($sql2);
?>
    <div style="margin-left: -20px;">
        <h1 class="content-heading">TEST RESULTS</h1>
        <hr>
        <p>Listed below are the results of certification tests that you have taken in the past. Please click on the link "Online" against the result set for which you want to view/print the certificate online.
        <br>
        Alternately, you can also order a printed certificate for any of the result sets listed below.</p>
        <br>
        <section id="middle">
            <div id="content" class="dashboard padding-20">
                <div class="col-md-12 no-padding">
                    <div id="panel-1" class="panel panel-default">
                        <div class="panel-heading">
                <span class="elipsis">

                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="datatable_sample">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Test Duration</th>
                                    <th>Results</th>
                                    <th>Certificates</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  if($result->num_rows>0){
                                    while($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $row['test_date'];?></td>
                                            <td><?php echo $row['test_time']."/".$row['test_duration'];?> secs</td>
                                            <td><?php echo $row['UWPM']."/".$row['UCPM']."/".$row['accuracy']."%/".$row['avg_CWPM'];?></td>
                                            <td>
                                                <a href="<?php echo $base_url;?>member/print_certificate.php?id=<?php echo $row['id'];?>">View</a>
                                                <a href="<?php echo $base_url;?>member/printed-certificates.php?id=<?php echo $row['id'];?>">Order</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>

        </section>
    </div>

<?php
include_once "../footer.php";
?>