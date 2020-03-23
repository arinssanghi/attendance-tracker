<?php
if (!$isAjax) {
    echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="content">';
}
?>

<h1 class="page-header">Schedule List</h1>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Schedule Name</th>
                <th>From Time</th>
                <th>To Time</th>
                <th>Total Strength</th>
                <th>Total Allocated</th>
                <th>Location</th>
                <th>Present</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($schedules) {
                foreach ($schedules as $schedule) {
                    ?>
                    <tr>
                        <td><?php echo $schedule['schedule_id']; ?></td>
                        <td><?php echo $schedule['schedule_name']; ?></td>
                        <td><?php echo $schedule['from_time']; ?></td>
                        <td><?php echo $schedule['to_time']; ?></td>
                        <td><?php echo $schedule['total_strength']; ?></td>
                        <td><?php echo $schedule['total_allocated']; ?></td>
                        <td><?php echo $schedule['location']; ?></td>
                        <td><?php echo $schedule['student_count']; ?></td>
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
        <form class="form-horizontal" id="add_to_schedule" method="post" autocomplete="off">
            <fieldset>

                <!-- Form Name -->
                <legend>Add to Schedule</legend>
                <p>Select a batch, tick mark the students whom you want to add to the schedule and click on <b>Save</b>.</p>
                <div class="row-fluid">
                    <div class="span6">
                        <!-- Select Basic -->
                        <div class="control-group users">
                            <label class="control-label" for="schedule_id">Select a Batch</label>
                            <div class="controls">
                                <select id="schedule_id" name="schedule_id" class="span12">
                                    <?php
                                    foreach ($schedules as $schedule) {
                                        echo "<option value='" . $schedule['schedule_id'] . "'>" . $schedule['schedule_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="controls">
                            <label class="control-label" for="days" style="font-size: 20px !important;">Select Students</label>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <?php
                        if ($students_set_one) {
                            ?>
                            <!-- Multiple Checkboxes -->
                            <div class="control-group">
                                <div class="controls">
                                    <?php foreach ($students_set_one as $student_set_one) { ?>
                                        <label class="checkbox" for="student-<?php echo $student_set_one['users_user_id']; ?>">
                                            <input name="student<?php echo $student_set_one['users_user_id']; ?>" id="student-<?php echo $student_set_one['users_user_id']; ?>" value="<?php echo $student_set_one['users_user_id']; ?>" type="checkbox">
                                            <?php echo $student_set_one['first_name'] . " " . substr($student_set_one['middle_name'], 0, 1) . " " . $student_set_one['last_name'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
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
                        if ($students_set_two) {
                            ?>
                            <!-- Multiple Checkboxes -->
                            <div class="control-group">
                                <div class="controls">
                                    <?php foreach ($students_set_two as $student_set_two) { ?>
                                        <label class="checkbox" for="student-<?php echo $student_set_two['users_user_id']; ?>">
                                            <input name="student<?php echo $student_set_two['users_user_id']; ?>" id="student-<?php echo $student_set_two['users_user_id']; ?>" value="<?php echo $student_set_two['users_user_id']; ?>" type="checkbox">
                                            <?php echo $student_set_two['first_name'] . " " . substr($student_set_two['middle_name'], 0, 1) . " " . $student_set_two['last_name'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;
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

<script type="text/javascript">
                    $wl = jQuery.noConflict();
                    $wl(document).ready(function() {
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