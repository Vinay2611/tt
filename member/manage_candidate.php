<?php
include_once "../header.php";
include_once "../db_con.php";
if(isset($_SESSION['is_logged_in']) && !empty($_SESSION['is_logged_in'])){
}else{
    header('Location: '.$base_url.'register.php');
    ob_end_flush();
    die();
}

if(isset($_REQUEST['type']) && $_REQUEST['type']=='del' && isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
    $del_id=$_REQUEST['id'];
    $sql11 = "delete from member where id=".$del_id;
    $result11 = $conn->query($sql11);
    header('Location: '.$base_url.'/member/manage_candidate.php');
    ob_end_flush();
    die();
}

$member_email=$_SESSION['is_logged_email'];
$sql = "SELECT * FROM member where email='$member_email'";
$result = $conn->query($sql);
$userData = $result->fetch_assoc();
$member_id=$userData['id'];
$sql2 = "SELECT * FROM member where corporate_member_id='$member_id' order by `created_on` desc";
$result2 = $conn->query($sql2);
?>
    <div style="margin-left: -20px;">
        <div class="pull-left">
            <h1 class="content-heading">CANDIDATE MANAGEMENT</h1>
        </div>
        <div class="pull-right">
            <a href="test_candidate.php" class="btn btn-sm btn-default">Add Candidate</a>
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
                                    <th>Employee Name</th>
                                    <th>Email Address</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  if($result2->num_rows>0){
                                    while($row = $result2->fetch_assoc()) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $row['first_name']." ".$row['last_name'];?></td>
                                            <td><?php echo $row['email'];?></td>
                                            <td>
                                                <a href="<?php echo $base_url;?>member/test-results.php?id=<?php echo $row['id'];?>">Results</a> &nbsp;<!-- <a href="<?php /*echo $base_url;*/?>member/test_candidate.php?id=<?php /*echo $row['id'];*/?>">Edit</a> -->&nbsp; <a href="?type=del&id=<?php echo $row['id'];?>" class="TableData" onclick="return(window.confirm('Are you sure you want to delete this record?'));">Delete</a>
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