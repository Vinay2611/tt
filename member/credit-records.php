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
$member_id=$userData['id'];
$sql2 = "SELECT * FROM creditflow where member_id='$member_id' order by `date` desc";
$result = $conn->query($sql2);
?>
    <div style="margin-left: -20px;">
        <h1 class="content-heading">CREDIT RECORDS</h1>
        <hr>
            <div class="pull-left">
                <strong>Credit Balance : <?php echo $credit_balance;?></strong>
            </div>
            <div class="pull-right">
                <a href="secure-purchase.php" class="btn btn-sm btn-default">Buy Credits</a>
            </div>
        <div class="clearfix"></div>
        <hr>
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
                                    <th>Transaction</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  if($result->num_rows>0){
                                    while($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $row['date'];?></td>
                                            <td><?php echo $row['narration'];?></td>
                                            <td><?php echo $row['credits'];?></td>
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