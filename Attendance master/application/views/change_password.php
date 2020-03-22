<style type="text/css">
    .error {
        color: #D8000C;
    }
</style>
<?php
if (!$isAjax) {
    echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="content">';
}
?>
<script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
<div class="widget widget-2 widget-body-white">
    <div class="widget-body">
        <form class="form-horizontal" id="change_password" method="post" autocomplete="off">
            <fieldset>

                <!-- Form Name -->
                <legend>Change Password</legend>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label" for="user_email">Email</label>
                            <div class="controls">
                                <input id="user_email" class="span12" name="user_email" value="<?php echo $email; ?>" type="text" disabled="disabled">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="control-group">
                            <label class="control-label" for="current_password">Current Password</label>
                            <div class="controls">
                                <input id="current_password" class="span12" name="current_password" placeholder="Current Password" type="password">

                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="control-group">
                            <label class="control-label" for="new_password">New Password</label>
                            <div class="controls">
                                <input id="new_password" class="span12" name="new_password" placeholder="New Password" type="password">

                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="control-group">
                            <label class="control-label" for="confirm_new_password">Confirm Password</label>
                            <div class="controls">
                                <input id="confirm_new_password" class="span12" name="confirm_new_password" placeholder="Confirm New Password" type="password">
                            </div>
                        </div>

                        <!-- Button (Double) -->
                        <div class="control-group">
                            <label class="control-label" for="save"></label>
                            <div class="controls">
                                <button id="save" name="save" class="btn btn-primary">Save</button>
                                <button id="cancel" name="cancel" type="reset" class="btn btn-inverse">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script src="<?php echo base_url("assets/js/jquery.validate.js"); ?>"></script>
<script src="<?php echo base_url('assets/js/change_password.js'); ?>"></script>
<script type="text/javascript">
    $wl = jQuery.noConflict();
    $wl(document).ready(function(){
        $wl('#content').show();
        $wl('div #img-loader img').remove();
   });
</script>
<?php
if (!$isAjax) {
    ?>
    </div>
    </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('assets/js/jquery-1.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/docs.js'); ?>"></script>
    </body>
    </html>
    <?php
}
?>