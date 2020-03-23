<?php
if (!$isAjax) {
    echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="content">';
}
?>
<link href="<?php echo base_url('assets/css/datatables/demo_table.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/datatables/TableTools.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/datatables/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/datatables/ZeroClipboard.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/datatables/TableTools.js'); ?>"></script>
<script type="text/javascript" charset="utf-8">
    $dtab = jQuery.noConflict();
    $dtab(document).ready(function() {
        $dtab('#attendance-table').dataTable({
            "sDom": 'T<"clear">lfrtip',
            "oTableTools": {
                "sSwfPath": "<?php echo base_url('assets/media/swf/copy_csv_xls_pdf.swf'); ?>"
            }
        });
    });
</script>
<h1 class="page-header">Attendance</h1>
<div class="widget widget-2 widget-body-white">
    <div class="widget-body">
        <form class="form-horizontal" id="get_attendance" method="post" autocomplete="off">
            <fieldset>

                <!-- Form Name -->
                <legend>Get Attendance</legend>
                <p>Select a batch from the drop down list to get attendance.</p>
                <div class="row-fluid">
                    <div class="span6">
                        <!-- Select Basic -->
                        <div class="control-group users">
                            <label class="control-label" for="batch_name">Select a Batch</label>
                            <div class="controls">
                                <select id="batch_name" name="batch_name" class="span12" onchange="get_attendance_report();">
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
            </fieldset>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped" id="attendance-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Schedule</th>
                <th>Student Name</th>
                <th>Present</th>
                <th>Fees Paid</th>
                <th>Fees Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($attendance_reports) {
                foreach ($attendance_reports as $attendance_report) {
                    ?>
                    <tr>
                        <td><?php echo $attendance_report['schedule_id']; ?></td>
                        <td><?php echo $attendance_report['schedule_name']; ?></td>
                        <td><?php echo $attendance_report['full_name']; ?></td>
                        <td><?php echo $attendance_report['attendance']; ?></td>
                        <td><?php echo $attendance_report['amount_paid']; ?></td>
                        <td><?php echo $attendance_report['amount_balance']; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
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