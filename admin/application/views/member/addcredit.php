<?php
if(isset($member_id) && !empty($member_id)){
}else{
    echo "Not Allowed To Access!";die;
}?>
<section id="middle">
    <div id="content" class="dashboard padding-20">
        <div class="col-md-12">
            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
									<span class="elipsis"><!-- panel title -->
										<strong>Add Credits</strong>
									</span>
                    <!-- right options -->
                    <ul class="options pull-right list-inline">
                        <li><a href="#" class="opt panel_colapse" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Colapse"></a></li>

                        <li><a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand"></i></a></li>

                        <li><a href="#" class="opt panel_close" data-confirm-title="Confirm" data-confirm-message="Are you sure you want to remove this panel?" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Close"><i class="fa fa-times"></i></a></li>

                    </ul>
                </div>
                <div class="panel-body">
                    <?php
                    $attributes = array('class' => '', 'id' => 'RecordForm');

                    echo form_open('user/add',$attributes);

                    ?>

                    <div class="col-lg-12 error-box">

                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6">
                                <label>Credits to add</label>
                                <input type="text" required class="form-control"  name="credits"  placeholder="">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="RecordID" name="RecordID" value="<?php echo isset($member_id)?$member_id:''?>">
                    </form>
                </div>

                <div class="panel-footer">
                    <input type="submit" class="btn btn-sm btn-success pull-right submit-btn" form="RecordForm"  value="Submit">

                    <div class="clearfix"></div>

                </div>

            </div>
            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
                <span class="elipsis">
                <strong>Credit Balance : <?php echo $credit_balance;?></strong>
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
                        <?php if(isset($data)){
                            foreach ($data as $d){
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $d['date'];?></td>
                                    <td><?php echo $d['narration'];?></td>
                                    <td><?php echo $d['credits'];?></td>
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


<script>
    $(function () {
        $("#RecordForm").submit(function (e) {
            e.preventDefault();
            $elm=$(".submit-btn");
            $elm.hide();
            $(".error-box").html('');
            $elm.after('<i class="fa fa-spinner fa-spin fa-1x fa-fw loading submit-loading"></i>');
            $.ajax({
                type	: "POST",
                url		: "addcredit",
                dataType : 'json',
                data	:$(this).serialize(),
                success	: function (resp) {
                    if(resp.success){
                        _toastr(resp.msg,"bottom-right","success",false);
                        setTimeout(function () {
                            location.reload();
                        },2000);
                    }else{
                        if(resp.validation_msg!==""){
                            $(".error-box").html('<div class="alert alert-mini alert-danger margin-bottom-30">'+resp.validation_msg+'</div>');
                        }
                        _toastr(resp.msg,"bottom-right","warning",false);
                    }
                    $(".submit-loading").remove();
                    $elm.show();
                }
            });
        });
    });
</script>
