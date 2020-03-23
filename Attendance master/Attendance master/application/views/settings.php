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
<h1 class="page-header">Staff Members</h1>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <!--<th>#</th>-->
                <th>Name</th>
                <th>email</th>
                <th>Last Access</th>
                <th>Attendace</th>
                <th>Fee Receipt</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($staff_members) {
                foreach ($staff_members as $staff_member) {
                    ?>
                    <tr>
                        <!--<td><?php // echo $staff_member['user_id']; ?></td>-->
                        <td><?php echo $staff_member['first_name'] . ' ' . $staff_member['last_name']; ?></td>
                        <td><?php echo $staff_member['email']; ?></td>
                        <td><?php echo $staff_member['last_access']; ?></td>
                        <td><?php echo ($staff_member['access_attendance'] == 1) ? "Yes" : "No"; ?></td>
                        <td><?php echo ($staff_member['access_fees_receipt'] == 1) ? "Yes" : "No"; ?></td>
                        <td><a style="cursor: pointer;" onclick="edit_staff(<?php echo $staff_member['user_id']; ?>)">Edit</a>&nbsp;&nbsp;<a style="cursor: pointer;" onclick="delete_user(<?php echo $staff_member['user_id']; ?>)">Delete</a></td>
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
        <form class="form-horizontal" id="create_staff" method="post" autocomplete="off">
            <fieldset>

                <!-- Form Name -->
                <legend>Create Staff</legend>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label" for="staff_first_name">First name</label>
                            <div class="controls"><input class="span12" id="staff_first_name" placeholder="First Name" name="staff_first_name" type="text" /></div>
                        </div>
                        <!-- Text input-->
                        <div class="control-group">
                            <label class="control-label" for="staff_middle_name">Middle Name</label>
                            <div class="controls">
                                <input id="staff_middle_name" class="span12"  name="staff_middle_name" placeholder="Middle Name" type="text">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="staff_last_name">Last name</label>
                            <div class="controls"><input class="span12" id="staff_last_name" name="staff_last_name" placeholder="Last Name" type="text" /></div>
                        </div>

                    </div>
                    <div class="span6">
                        <!-- Text input-->
                        <div class="control-group">
                            <label class="control-label" for="staff_email">Email</label>
                            <div class="controls">
                                <input id="staff_email" class="span12" name="staff_email" placeholder="Email" type="text">

                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="control-group">
                            <label class="control-label" for="staff_password">Password</label>
                            <div class="controls">
                                <input id="staff_password" class="span12" name="staff_password" placeholder="Password" type="password">

                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="control-group">
                            <label class="control-label" for="staff_confirm_password">Confirm Password</label>
                            <div class="controls">
                                <input id="staff_confirm_password" class="span12" name="staff_confirm_password" placeholder="Confirm Password" type="password">
                            </div>
                        </div>

                        <!-- Multiple Checkboxes -->
                        <div class="control-group">
                            <label class="control-label" for="checkboxes">Access</label>
                            <div class="controls">
                                <label class="checkbox" for="attendance">
                                    <input name="attendance" id="attendance" value="attendance" type="checkbox">
                                    Attendance
                                </label>
                                <label class="checkbox" for="fee_recipt">
                                    <input name="fee_recipt" id="fee_recipt" value="fee_recipt" type="checkbox">
                                    Fee Receipts
                                </label>
                            </div>
                        </div>
                        <input type="hidden" value="add" name="staff_action" id="staff_action" />
                        <input type="hidden" value="" name="staff_id" id="staff_id" />
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
<script src="<?php echo base_url('assets/js/create_staff.js'); ?>"></script>
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