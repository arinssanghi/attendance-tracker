<?php
if (!$isAjax) {
    echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="content">';
}
?>
<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/less/datepicker.less'); ?>" rel="stylesheet">
<!-- Include JQuery UI (Required for calendar plugin.) -->
<script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
    $dob = jQuery.noConflict();
    $dob(function() {
        $dob('#dob').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>
<style type="text/css">
    .error {
        color: #D8000C;
    }
</style>
<h1 class="page-header">Admissions</h1>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <!--<th>#</th>-->
                <th>Name</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Frequency</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($students) {
                foreach ($students as $student) {
                    ?>
                    <tr>
                        <!--<td><?php // echo $student['user_id'];   ?></td>-->
                        <td><?php echo $student['first_name'] . ' ' . $student['last_name']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                        <td><?php echo $student['mobile']; ?></td>
                        <td><?php echo $student['course_frequency_name']; ?></td>
                        <td><a style="cursor: pointer;" onclick="edit_user(<?php echo $student['user_id']; ?>)">Edit</a>&nbsp;&nbsp;<a style="cursor: pointer;" onclick="delete_user(<?php echo $student['user_id']; ?>)">Delete</a></td>
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
        <form class="form-horizontal" id="create_user" method="post" autocomplete="off">
            <fieldset>

                <!-- Form Name -->
                <legend>Create User</legend>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label" for="first_name">First name</label>
                            <div class="controls"><input class="span12" id="first_name" placeholder="First Name" name="first_name" type="text" /></div>
                        </div>
                        <!-- Text input-->
                        <div class="control-group">
                            <label class="control-label" for="middle_name">Middle Name</label>
                            <div class="controls">
                                <input id="middle_name" class="span12"  name="middle_name" placeholder="Middle Name" type="text">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="last_name">Last name</label>
                            <div class="controls"><input class="span12" id="last_name" name="last_name" placeholder="Last Name" type="text" /></div>
                        </div>
                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="dob">Date of Birth</label>
                            <div class="controls">
                                <input id="dob" class="input-small" name="dob" placeholder="DOB" type="text">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="control-group">
                            <label class="control-label" for="email">Email</label>
                            <div class="controls">
                                <input id="email" class="span12" name="email" placeholder="Email" type="text">

                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="control-group">
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                                <input id="password" class="span12" name="password" placeholder="Password" type="password">

                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="control-group">
                            <label class="control-label" for=" confirm_password">Confirm Password</label>
                            <div class="controls">
                                <input id="confirm_password" class="span12" name="confirm_password" placeholder="Confirm Password" type="password">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="mobile_number">Mobile Number</label>
                            <div class="controls">
                                <input id="mobile_number" class="span12" name="mobile_number" placeholder="Mobile Number" class="span12" type="text">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="alternate_number">Alternate Number</label>
                            <div class="controls">
                                <input id="alternate_number" class="span12" name="alternate_number" placeholder="Alternate Number" class="span12" type="text">

                            </div>
                        </div>
                        <!-- Multiple Radios -->
                        <div class="control-group users">
                            <label class="control-label" for="frequency">Frequency</label>
                            <div class="controls">
                                <label class="radio" for="three_months">
                                    <input name="frequency" id="three_months" value="1" checked="checked" type="radio">
                                    3 Months
                                </label>
                                <label class="radio" for="weekly">
                                    <input name="frequency" id="weekly" value="2" type="radio">
                                    Weekly Once/Twice
                                </label>
                                <label class="radio" for="fixed_courses">
                                    <input name="frequency" id="fixed_courses" value="3" type="radio">
                                    Fixed Courses
                                </label>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="stree1">Street 1</label>
                            <div class="controls">
                                <input id="street1" name="street1" placeholder="Street 1" class="span12" type="text">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="street2">Street 2</label>
                            <div class="controls">
                                <input id="street2" name="street2" placeholder="Street 2" class="span12" type="text">

                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="city">City</label>
                            <div class="controls">
                                <input id="city" name="city" placeholder="City" class="span12" type="text">

                            </div>
                        </div>



                    </div>
                    <div class="span6">

                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="state">State</label>
                            <div class="controls">
                                <input id="state" name="state" placeholder="State" class="span12" type="text">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="zip">Zip</label>
                            <div class="controls">
                                <input id="zip" name="zip" placeholder="Zip" class="span12" type="text">

                            </div>
                        </div>

                        <!-- Select Basic -->
                        <div class="control-group users">
                            <label class="control-label" for="country">Country</label>
                            <div class="controls">
                                <select id="country" name="country" class="span12">
                                    <option>India</option>
                                    <option>USA</option>
                                </select>
                            </div>
                        </div>
                        <?php
                        if ($instruments) {
                            ?>
                            <!-- Multiple Checkboxes -->
                            <div class="control-group users">
                                <label class="control-label" for="checkboxes">Instrument</label>
                                <div class="controls">
                                    <?php foreach ($instruments as $instrument) { ?>
                                        <label class="checkbox" for="instrument<?php echo $instrument['instrument_id']; ?>">
                                            <input name="instrument<?php echo $instrument['instrument_id']; ?>" id="instrument<?php echo $instrument['instrument_id']; ?>" class='instrument' value="<?php echo $instrument['instrument_id']; ?>" type="checkbox">
                                            <?php echo $instrument['instrument_name']; ?>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="school">School</label>
                            <div class="controls">
                                <input id="school" name="school" placeholder="School" class="span12" type="text">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="standard">Standard</label>
                            <div class="controls">
                                <input id="standard" name="standard" placeholder="Standard" class="span12" type="text">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="emergency_contact">Emergency Contact</label>
                            <div class="controls">
                                <input id="emergency_contact" name="emergency_contact" placeholder="Emergency Contact" class="span12" type="text">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="special_needs">Special Needs</label>
                            <div class="controls">
                                <input id="special_needs" name="special_needs" placeholder="Special Needs" class="span12" type="text">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="course_duration">Course Duration</label>
                            <div class="controls">
                                <input id="course_duration" name="course_duration" placeholder="Course Duration" class="span12" type="text">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="course_goals">Course Goals</label>
                            <div class="controls">
                                <input id="course_goals" name="course_goals" placeholder="Course Goals" class="span12" type="text">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group users">
                            <label class="control-label" for="grades_completed">Grades Completed</label>
                            <div class="controls">
                                <input id="grades_completed" name="grades_completed" placeholder="Grades Completed" class="span12" type="text">

                            </div>
                        </div>

                        <!-- Textarea -->
                        <div class="control-group users">
                            <label class="control-label" for="instrument_details">Instrument Details</label>
                            <div class="controls">                     
                                <textarea id="instrument_details" class="span12" name="instrument_details"></textarea>
                            </div>
                        </div>

                        <input type="hidden" value="add" name="action" id="action" />
                        <input type="hidden" value="" name="user_id" id="user_id" />
                        <input type="hidden" value="" name="address_id" id="address_id" />
                        <!-- Button (Double) -->
                        <div class="control-group">
                            <label class="control-label" for="save"></label>
                            <div class="controls">
                                <button id="save" name="save" class="btn btn-primary">Save</button>
                                <button id="cancel" name="cancel" onclick="reset_form();" type="reset" class="btn btn-inverse">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script src="<?php echo base_url("assets/js/jquery.validate.js"); ?>"></script>
<script src="<?php echo base_url('assets/js/add_users.js'); ?>"></script>
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
    <!--<script src="<?php // echo base_url('assets/js/jquery-1.js');             ?>"></script>-->
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/docs.js'); ?>"></script>

            <!--<script src="<?php // echo base_url("assets/js/jquery.validate.js");   ?>"></script>-->
    <?php if (!$isAjax) { ?>
        <script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
    <?php } ?>
    </body>
    </html>
    <?php
}
?>