<script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script><section id="middle">    <div id="content" class="dashboard padding-20">        <div class="col-md-12">            <div id="panel-1" class="panel panel-default">                <div class="panel-heading">									<span class="elipsis"><!-- panel title -->										<strong>Add Product</strong>									</span>                    <!-- right options -->                    <ul class="options pull-right list-inline">                        <li><a href="#" class="opt panel_colapse" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Colapse"></a></li>                        <li><a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand"></i></a></li>                        <li><a href="#" class="opt panel_close" data-confirm-title="Confirm" data-confirm-message="Are you sure you want to remove this panel?" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Close"><i class="fa fa-times"></i></a></li>                    </ul>                </div>                <div class="panel-body">                    <?php                    $attributes = array('class' => 'form-horizontal', 'id' => 'RecordForm');                    echo form_open('user/add',$attributes);                    ?>                    <div class="col-lg-12 error-box">                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2">Products</label>                        <div class="col-sm-10">                            <input type="text" class="form-control" required name="product_title" value="<?php echo isset($form_data->product_title)?$form_data->product_title:''?>">                        </div>                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2">Test Credits</label>                        <div class="col-sm-10">                            <input type="number" class="form-control" required name="test_credits" value="<?php echo isset($form_data->test_credits)?$form_data->test_credits:'0'?>">                        </div>                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2">Free Credits</label>                        <div class="col-sm-10">                            <input type="number" class="form-control" required name="free_credits" value="<?php echo isset($form_data->free_credits)?$form_data->free_credits:'0'?>">                        </div>                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2">Printed Certificates</label>                        <div class="col-sm-10">                            <input type="number" class="form-control" required name="printed_certificates" value="<?php echo isset($form_data->printed_certificates)?$form_data->printed_certificates:'0'?>">                        </div>                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2">Price</label>                        <div class="col-sm-10">                            <input type="number" class="form-control" required name="price" value="<?php echo isset($form_data->price)?$form_data->price:'0'?>">                        </div>                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2">Upgrade to offer:</label>                        <div class="col-sm-10">                            <label class="radio">                                <input type="radio" required name="upgrade_to" value="0" <?php echo isset($form_data->upgrade_to) && $form_data->upgrade_to=="0"?'checked':''?>>                                <i></i> None                            </label><br>                            <?php                            $where="";                            if(isset($form_data->id)){                                $where=" where id<>".$form_data->id;                            }                            $sql = "SELECT * FROM product".$where;                            $query = $this->db->query($sql);                            $result=$query->result_array();                            foreach ($result as $r){                             ?>                                <label class="radio">                                    <input type="radio" name="upgrade_to" <?php echo isset($form_data->upgrade_to) && $form_data->upgrade_to==$r['id']?'checked':''?> value="<?php echo $r['id'];?>">                                    <i></i> <?php echo $r['product_title'];?>                                </label><br>                            <?php                            }                            ?>                        </div>                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2">Upgrade offer text</label>                        <div class="col-sm-12">                            <textarea class="form-control" id="ckeditor1" ><?php echo isset($form_data->upgrade_text)?$form_data->upgrade_text:''?></textarea>                        </div>                    </div>                    <input type="hidden" name="editordata" id="editordata" value="">                    <input type="hidden" id="RecordID" name="RecordID" value="<?php echo isset($form_data->id)?$form_data->id:''?>">                    </form>                </div>                <div class="panel-footer">                    <div class="form-group">                        <div class="col-sm-offset-2 col-sm-10">                            <input type="submit" class="btn btn-sm btn-success pull-right submit-btn" form="RecordForm"  value="Submit">                        </div>                    </div>                    <div class="clearfix"></div>                </div>            </div>            <!-- / -->        </div>    </div></section><script>    $(function () {      //  CKEDITOR.replace('CK');        var edd=CKEDITOR.replace( 'ckeditor1');        $("#RecordForm").submit(function (e) {            e.preventDefault();            var editorText = CKEDITOR.instances.ckeditor1.getData();            $("#editordata").val(editorText);            $elm=$(".submit-btn");            $elm.hide();            $(".error-box").html('');            $elm.after('<i class="fa fa-spinner fa-spin fa-1x fa-fw loading submit-loading"></i>');            $.ajax({                type	: "POST",                url		: "add",                dataType : 'json',                data	:$(this).serialize(),                success	: function (resp) {                    if(resp.success){                        _toastr(resp.msg,"bottom-right","success",false);                        setTimeout(function () {                            location.reload();                        },2000);                    }else{                        if(resp.validation_msg!==""){                            $(".error-box").html('<div class="alert alert-mini alert-danger margin-bottom-30">'+resp.validation_msg+'</div>');                        }                        _toastr(resp.msg,"bottom-right","warning",false);                    }                    $(".submit-loading").remove();                     $elm.show();                }            });        });    });</script>