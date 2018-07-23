<?php
include_once "header.php";
include_once "db_con.php";

$sql = "SELECT * FROM article ORDER by article_date desc";
$result = $conn->query($sql);
?>
<style>
    .test-content{
        display: none;
    }
    #SubmitTest{
        display: none;
    }
</style>

<div class="row-diff">
    <h1 class="content-heading">LIBRARY</h1>
    <hr>

    <br>

    <table style="width: 100%">
        <tr>
            <td>TITLE</td>
            <td>DATE ADDED</td>
        </tr>
        <?php
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td width="70%"><a href="article-view.php?id=<?php echo $row['id'];?>"><?php echo $row['article_title'];?></a></td>
                    <td width="30%"><?php echo $row['article_date'];?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>
<?php
include_once "footer.php";
?>