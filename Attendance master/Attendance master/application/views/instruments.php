<?php
if (!$isAjax) {
    echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="content">';
}
?>
<script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
<style type="text/css">
    .error {
        color: #D8000C;
    }
</style>
<h1 class="page-header">Instruments</h1>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($instruments) {
                foreach ($instruments as $instrument) {
                    ?>
                    <tr>
                        <td><?php echo $instrument['instrument_id']; ?></td>
                        <td><?php echo $instrument['instrument_name']; ?></td>
                        <td><a style="cursor: pointer;" onclick="edit_instrument(<?php echo $instrument['instrument_id']; ?>);">Edit</a>&nbsp;&nbsp;<a style="cursor: pointer;" onclick="delete_instrument(<?php echo $instrument['instrument_id']; ?>);">Delete</a></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

<div class="widget widget-2 widget-body-white">
    <div class="widget-body">
        <form class="form-horizontal" id="create_instrument" method="post" autocomplete="off">
            <fieldset>

                <!-- Form Name -->
                <legend>Add new</legend>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label" for="instrument_name">Instrument Name</label>
                            <div class="controls"><input class="span12" id="instrument_name" placeholder="Instrument Name" name="instrument_name" type="text" /></div>
                        </div>
                        <input type="hidden" value="add" name="instrument_action" id="instrument_action" />
                        <input type="hidden" value="" name="instrument_id" id="instrument_id" />
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
<script src="<?php echo base_url('assets/js/instruments.js'); ?>"></script>
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
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/docs.js'); ?>"></script>
    </body>
    </html>
    <?php
}
?>