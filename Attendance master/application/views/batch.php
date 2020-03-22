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
<h1 class="page-header">Batch</h1>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>From Time</th>
                <th>To Time</th>
                <th>Total Strength</th>
                <th>Days</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($batches) {
                foreach ($batches as $batch) {
                    ?>
                    <tr>
                        <td><?php echo $batch['batch_id']; ?></td>
                        <td><?php echo $batch['batch_name']; ?></td>
                        <td><?php echo $batch['from_time']; ?></td>
                        <td><?php echo $batch['to_time']; ?></td>
                        <td><?php echo $batch['batch_strength']; ?></td>
                        <td><?php echo $batch['batch_days']; ?></td>
                        <td><a style="cursor: pointer;" onclick="edit_batch(<?php echo $batch['batch_id']; ?>);">Edit</a>&nbsp;&nbsp;<a style="cursor: pointer;" onclick="delete_batch(<?php echo $batch['batch_id']; ?>);">Delete</a></td>
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
        <form class="form-horizontal" id="create_batch" method="post" autocomplete="off">
            <fieldset>

                <!-- Form Name -->
                <legend>Create Batch</legend>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label" for="batch_name">Batch Name</label>
                            <div class="controls"><input class="span12" id="batch_name" placeholder="Batch Name" name="batch_name" type="text" /></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="batch_strength">Total Strength</label>
                            <div class="controls"><input class="span12" id="batch_strength" name="batch_strength" placeholder="Total Strength" type="text" /></div>
                        </div>
                        <!-- Text input-->
                        <div class="control-group">
                            <label class="control-label" for="from_time">From Time</label>
                            <div class="controls">
                                <input id="from_time" class="span12" name="from_time" placeholder="From Time" type="text">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="to_time">To Time</label>
                            <div class="controls"><input class="span12" id="to_time" name="to_time" placeholder="To Time" type="text" /></div>
                        </div>
                        <input type="hidden" value="add" name="batch_action" id="batch_action" />
                        <input type="hidden" value="" name="batch_id" id="batch_id" />
                        <!-- Button (Double) -->
                        <div class="control-group">
                            <label class="control-label" for="save"></label>
                            <div class="controls">
                                <button id="save" name="save" class="btn btn-primary">Save</button>
                                <button id="cancel" name="cancel" type="reset" class="btn btn-inverse">Reset</button>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <?php
                        if ($days) {
                            ?>
                            <!-- Multiple Checkboxes -->
                            <div class="control-group">
                                <label class="control-label" for="days">Days</label>
                                <div class="controls">
                                    <?php foreach ($days as $day) { ?>
                                        <label class="checkbox" for="days-<?php echo $day['day_id']; ?>">
                                            <input name="<?php echo $day['day_id']; ?>" id="days-<?php echo $day['day_id']; ?>" value="<?php echo $day['day_id']; ?>" type="checkbox">
                                            <?php echo $day['day_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script src="<?php echo base_url("assets/js/jquery.validate.js"); ?>"></script>
<script src="<?php echo base_url('assets/js/create_batch.js'); ?>"></script>
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