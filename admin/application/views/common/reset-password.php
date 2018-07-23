<section id="middle">
    <div id="content" class="dashboard padding-20">
        <div class="col-md-12">
            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading">
									<span class="elipsis"><!-- panel title -->
										<strong>Password Reset</strong>
									</span>
                    <!-- right options -->
                    <ul class="options pull-right list-inline">
                        <li><a href="#" class="opt panel_colapse" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Colapse"></a></li>

                        <li><a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand"></i></a></li>

                        <li><a href="#" class="opt panel_close" data-confirm-title="Confirm" data-confirm-message="Are you sure you want to remove this panel?" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Close"><i class="fa fa-times"></i></a></li>

                    </ul>
                </div>
                <div class="panel-body">
                    <div style="color: red">
                        <?php if(!empty($msg)){
                            echo $msg;
                        }?>
                    </div>
                    <br>
                    <?php
                    $attributes = array('class' => 'form-horizontal', 'id' => 'RecordForm');

                    echo form_open('passwordreset/index',$attributes);

                    ?>

                    <div class="col-lg-12 error-box">

                    </div>


                    <div class="form-group">
                        <label class="control-label col-sm-2">Old Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" required name="old_password" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">New Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" required name="password" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Confirm New Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" required name="conf_password" >
                        </div>
                    </div>

                    </form>
                </div>

                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-sm btn-success pull-right submit-btn" form="RecordForm"  value="Submit">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

            <!-- / -->


        </div>

    </div>

</section>