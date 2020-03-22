<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <!--<li class="active"><a style="cursor: pointer;" id="dashboard">Overview</a></li>-->
                <li class="active"><a style="cursor: pointer;" href="<?php echo site_url('user/my_calendar'); ?>" id="my_calendar">My Calendar</a></li>
                <?php if ($role == md5(1) || $role == md5(2)) { ?>
                    <li><a style="cursor: pointer;" id="add_users">Admissions</a></li>
                    <?php if ($access_fees_receipt == 1) { ?>
                        <li><a style="cursor: pointer;" id="fee_receipts">Fee Receipts</a></li>
                    <?php } ?>
                    <?php if ($access_attendance == 1) { ?>
                        <li><a style="cursor: pointer;" id="schedule_list">Schedule List</a></li>
                        <li><a style="cursor: pointer;" id="attendance">Attendance Report</a></li>
                        <li><a style="cursor: pointer;" id="attendance_register">Attendance Register</a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
            <?php if ($role == md5(1) || $role == md5(2)) { ?>
                <ul class="nav nav-sidebar">
                    <!--<li><a style="cursor: pointer;" id="batch">Batch</a></li>-->
                    <li><a style="cursor: pointer;" id="instruments">Instruments</a></li>
                    <!--<li><a href="">One more nav</a></li>-->
                    <!--<li><a href="">Another nav item</a></li>-->
                    <!--<li><a href="">More navigation</a></li>-->
                </ul>
            <?php } ?>
            <!--            <ul class="nav nav-sidebar">
                            <li><a href="">Nav item again</a></li>
                            <li><a href="">One more nav</a></li>
                            <li><a href="">Another nav item</a></li>
                        </ul>-->
        </div>
        <div id="img-loader"></div>
        <script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
        <script type="text/javascript">
            var stateObj = {foo: "bar"};
            $jq = jQuery.noConflict();
            $jq('li #add_users').click(function(event) {
                event.preventDefault();
                $jq(".ui-datepicker").remove();
                $jq('#content').html('');
                $jq(".row div ul li").each(function(index, element) {
                    if ($jq(element).hasClass("active")) {
                        $jq(element).removeClass('active');
                    }
                });
                $jq("#add_users").parent().addClass('active');
                $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                $jq('div #img-loader img').addClass('Absolute-Center');
                $jq.ajax({
                    url: '<?php echo site_url('user/add_users'); ?>',
                    type: 'POST',
                    success: function(output_string) {
                        // here you need to inject the new data in the page 
                        // in place of the old data
                        history.pushState(stateObj, "", "<?php echo site_url('user/add_users'); ?>");

                        $jq('#content').attr("style", 'display: none;');
                        $jq('#content').html(output_string);
                    }
                });
            });
            $jq('li #dashboard').click(function(event) {
                event.preventDefault();
                $jq(".ui-datepicker").remove();
                $jq('#content').html('');
                $jq(".row div ul li").each(function(index, element) {
                    if ($jq(element).hasClass("active")) {
                        $jq(element).removeClass('active');
                    }
                });
                $jq("#dashboard").parent().addClass('active');
                $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                $jq('div #img-loader img').addClass('Absolute-Center');
                $jq.ajax({
                    url: '<?php echo site_url('user/dashboard'); ?>',
                    type: 'POST',
                    success: function(output_string) {
                        // here you need to inject the new data in the page 
                        // in place of the old data
                        history.pushState(stateObj, "", "<?php echo site_url('user/dashboard'); ?>");
                        $jq('#content').attr("style", 'display: none;');
                        $jq('#content').html(output_string);
                    }
                });
            });
            $jq('li #fee_receipts').click(function(event) {
                event.preventDefault();
                $jq(".ui-datepicker").remove();
                $jq('#content').html('');
                $jq(".row div ul li").each(function(index, element) {
                    if ($jq(element).hasClass("active")) {
                        $jq(element).removeClass('active');
                    }
                });
                $jq("#fee_receipts").parent().addClass('active');
                $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                $jq('div #img-loader img').addClass('Absolute-Center');
                $jq.ajax({
                    url: '<?php echo site_url('user/fee_receipts'); ?>',
                    type: 'POST',
                    success: function(output_string) {
                        // here you need to inject the new data in the page 
                        // in place of the old data
                        history.pushState(stateObj, "", "<?php echo site_url('user/fee_receipts'); ?>");
                        $jq('#content').attr("style", 'display: none;');
                        $jq('#content').html(output_string);
                    }
                });
            });

            $jq('li #schedule_list').click(function(event) {
                event.preventDefault();
                $jq(".ui-datepicker").remove();
                $jq('#content').html('');
                $jq(".row div ul li").each(function(index, element) {
                    if ($jq(element).hasClass("active")) {
                        $jq(element).removeClass('active');
                    }
                });
                $jq("#schedule_list").parent().addClass('active');
                $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                $jq('div #img-loader img').addClass('Absolute-Center');
                $jq.ajax({
                    url: '<?php echo site_url('user/schedule_list'); ?>',
                    type: 'POST',
                    success: function(output_string) {
                        // here you need to inject the new data in the page 
                        // in place of the old data
                        history.pushState(stateObj, "", "<?php echo site_url('user/schedule_list'); ?>");
                        $jq('#content').attr("style", 'display: none;');
                        $jq('#content').html(output_string);
                    }
                });
            });

            $jq('li #attendance').click(function(event) {
                event.preventDefault();
                $jq(".ui-datepicker").remove();
                $jq('#content').html('');
                $jq(".row div ul li").each(function(index, element) {
                    if ($jq(element).hasClass("active")) {
                        $jq(element).removeClass('active');
                    }
                });
                $jq("#attendance").parent().addClass('active');
                $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                $jq('div #img-loader img').addClass('Absolute-Center');
                $jq.ajax({
                    url: '<?php echo site_url('user/attendance'); ?>',
                    type: 'POST',
                    success: function(output_string) {
                        // here you need to inject the new data in the page 
                        // in place of the old data
                        history.pushState(stateObj, "", "<?php echo site_url('user/attendance'); ?>");
                        $jq('#content').attr("style", 'display: none;');
                        $jq('#content').html(output_string);
                    }
                });
            });
            $jq('li #attendance_register').click(function(event) {
                event.preventDefault();
                $jq(".ui-datepicker").remove();
                $jq('#content').html('');
                $jq(".row div ul li").each(function(index, element) {
                    if ($jq(element).hasClass("active")) {
                        $jq(element).removeClass('active');
                    }
                });
                $jq("#attendance_register").parent().addClass('active');
                $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                $jq('div #img-loader img').addClass('Absolute-Center');
                $jq.ajax({
                    url: '<?php echo site_url('user/attendance_register'); ?>',
                    type: 'POST',
                    success: function(output_string) {
                        // here you need to inject the new data in the page 
                        // in place of the old data
                        history.pushState(stateObj, "", "<?php echo site_url('user/attendance_register'); ?>");
                        $jq('#content').attr("style", 'display: none;');
                        $jq('#content').html(output_string);
                    }
                });
            });
            $jq('li #batch').click(function(event) {
                event.preventDefault();
                $jq(".ui-datepicker").remove();
                $jq('#content').html('');
                $jq(".row div ul li").each(function(index, element) {
                    if ($jq(element).hasClass("active")) {
                        $jq(element).removeClass('active');
                    }
                });
                $jq("#batch").parent().addClass('active');
                $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                $jq('div #img-loader img').addClass('Absolute-Center');
                $jq.ajax({
                    url: '<?php echo site_url('user/batch'); ?>',
                    type: 'POST',
                    success: function(output_string) {
                        // here you need to inject the new data in the page 
                        // in place of the old data
                        history.pushState(stateObj, "", "<?php echo site_url('user/batch'); ?>");
                        $jq('#content').attr("style", 'display: none;');
                        $jq('#content').html(output_string);
                    }
                });
            });

            $jq('li #instruments').click(function(event) {
                event.preventDefault();
                $jq(".ui-datepicker").remove();
                $jq('#content').html('');
                $jq(".row div ul li").each(function(index, element) {
                    if ($jq(element).hasClass("active")) {
                        $jq(element).removeClass('active');
                    }
                });
                $jq("#add_users").parent().addClass('active');
                $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                $jq('div #img-loader img').addClass('Absolute-Center');
                $jq.ajax({
                    url: '<?php echo site_url('user/instruments'); ?>',
                    type: 'POST',
                    success: function(output_string) {
                        // here you need to inject the new data in the page 
                        // in place of the old data
                        history.pushState(stateObj, "", "<?php echo site_url('user/instruments'); ?>");
                        $jq('#content').attr("style", 'display: none;');
                        $jq('#content').html(output_string);
                    }
                });
            });
            $jq(function() {
                $jq('#save').removeAttr('disabled');
                $jq(document).on('submit', '#create_user', function(e) {
                    e.preventDefault();
                    $jq('#save').attr('disabled', 'true');
                    var form = $jq(this);
                    //                $('#error').hide();
                    var faction = "<?php echo site_url('user/create_user'); ?>";
                    var fdata = form.serialize();

                    $jq.post(faction, fdata, function(rdata) {
                        var json = jQuery.parseJSON(rdata);
                        if (json.isSuccessful) {
                            $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                            $jq('div #img-loader img').addClass('Absolute-Center');
                            $jq.ajax({
                                url: '<?php echo site_url('user/add_users'); ?>',
                                type: 'POST',
                                success: function(output_string) {
                                    $jq('#content').attr("style", 'display: none;');
                                    $jq('#content').html(output_string);
                                }
                            });
                        } else {
                            $jq('#save').removeAttr('disabled');
                            alert(json.message);
                            //                        $('#errorMessage').html(json.message.message);
                            //                                        $('#error').show();
                            form.children('input[name="email"]').select();
                        }
                    });
                    return false;
                    $jq('#save').removeAttr('disabled');
                });
                $jq(document).on('submit', '#create_staff', function(e) {
                    e.preventDefault();
                    var form = $jq(this);
                    var faction = "<?php echo site_url('user/create_staff'); ?>";
                    var fdata = form.serialize();

                    $jq.post(faction, fdata, function(rdata) {
                        var json = jQuery.parseJSON(rdata);
                        if (json.isSuccessful) {
                            $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                            $jq('div #img-loader img').addClass('Absolute-Center');
                            $jq.ajax({
                                url: '<?php echo site_url('user/settings'); ?>',
                                type: 'POST',
                                success: function(output_string) {
                                    $jq('#content').attr("style", 'display: none;');
                                    $jq('#content').html(output_string);

                                }
                            });
                        } else {
                            alert(json.message);
                            form.children('input[name="email"]').select();
                        }
                    });
                    return false;
                });


                $jq(document).on('submit', '#add_to_schedule', function(e) {
                    e.preventDefault();
                    var form = $jq(this);
                    var faction = "<?php echo site_url('user/add_students_to_schedule'); ?>";
                    var fdata = form.serialize();

                    $jq.post(faction, fdata, function(rdata) {
                        var json = jQuery.parseJSON(rdata);
                        if (json.isSuccessful) {
                            $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                            $jq('div #img-loader img').addClass('Absolute-Center');
                            $jq.ajax({
                                url: '<?php echo site_url('user/schedule_list'); ?>',
                                type: 'POST',
                                success: function(output_string) {
                                    $jq('#content').attr("style", 'display: none;');
                                    $jq('#content').html(output_string);
                                }
                            });
                        } else {
                            alert(json.message);
                        }
                    });
                    return false;
                });


                $jq(document).on('submit', '#set_attendance', function(e) {
                    e.preventDefault();
                    var form = $jq(this);
                    var faction = "<?php echo site_url('user/save_attendance'); ?>";
                    var fdata = form.serialize();

                    $jq.post(faction, fdata, function(rdata) {
                        var json = jQuery.parseJSON(rdata);
                        if (json.isSuccessful) {
                            $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                            $jq('div #img-loader img').addClass('Absolute-Center');
                            $jq.ajax({
                                url: '<?php echo site_url('user/attendance_register'); ?>',
                                type: 'POST',
                                success: function(output_string) {
                                    $jq('#content').attr("style", 'display: none;');
                                    $jq('#content').html(output_string);
                                }
                            });
                        } else {
                            alert(json.message);
                        }
                    });
                    return false;
                });


                $jq(document).on('submit', '#create_batch', function(e) {
                    e.preventDefault();
                    var form = $jq(this);
                    var faction = "<?php echo site_url('user/create_batch'); ?>";
                    var fdata = form.serialize();

                    $jq.post(faction, fdata, function(rdata) {
                        var json = jQuery.parseJSON(rdata);
                        if (json.isSuccessful) {
                            $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                            $jq('div #img-loader img').addClass('Absolute-Center');
                            $jq.ajax({
                                url: '<?php echo site_url('user/batch'); ?>',
                                type: 'POST',
                                success: function(output_string) {
                                    $jq('#content').attr("style", 'display: none;');
                                    $jq('#content').html(output_string);
                                }
                            });
                        } else {
                            alert(json.message);
                            form.children('input[name="email"]').select();
                        }
                    });
                    return false;
                });
                $jq(document).on('submit', '#create_fee_receipt', function(e) {
                    e.preventDefault();
                    var form = $jq(this);
                    var faction = "<?php echo site_url('user/create_fee_receipts'); ?>";
                    var fdata = form.serialize();

                    $jq.post(faction, fdata, function(rdata) {
                        var json = jQuery.parseJSON(rdata);
                        if (json.isSuccessful) {
                            $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                            $jq('div #img-loader img').addClass('Absolute-Center');
                            $jq.ajax({
                                url: '<?php echo site_url('user/fee_receipts'); ?>',
                                type: 'POST',
                                success: function(output_string) {
                                    $jq('#content').attr("style", 'display: none;');
                                    $jq('#content').html(output_string);
                                }
                            });
                        } else {
                            alert(json.message);
                            form.children('input[name="name"]').select();
                        }
                    });
                    return false;
                });
                $jq(document).on('submit', '#change_password', function(e) {
                    e.preventDefault();
                    $jq('#save').attr('disabled', 'true');
                    var form = $jq(this);
                    var faction = "<?php echo site_url('user/update_password'); ?>";
                    var fdata = form.serialize();

                    $jq.post(faction, fdata, function(rdata) {
                        var json = jQuery.parseJSON(rdata);
                        if (json.isSuccessful) {
                            $jq('#change_password')[0].reset();
                            $jq('#save').removeAttr('disabled');
                            alert(json.message);
                        } else {
                            $jq('#save').removeAttr('disabled');
                            alert(json.message);
                            form.children('input[name="current_password"]').select();
                        }
                    });
                    return false;
                });

                $jq(document).on('submit', '#create_instrument', function(e) {
                    e.preventDefault();
                    $jq('#save').attr('disabled', 'true');
                    var form = $jq(this);
                    var faction = "<?php echo site_url('user/add_update_instrument'); ?>";
                    var fdata = form.serialize();

                    $jq.post(faction, fdata, function(rdata) {
                        var json = jQuery.parseJSON(rdata);
                        if (json.isSuccessful) {
                            $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                            $jq('div #img-loader img').addClass('Absolute-Center');
                            $jq.ajax({
                                url: '<?php echo site_url('user/instruments'); ?>',
                                type: 'POST',
                                success: function(output_string) {
                                    $jq('#content').attr("style", 'display: none;');
                                    $jq('#content').html(output_string);
                                }
                            });
                        } else {
                            $jq('#save').removeAttr('disabled');
                            alert(json.message);
                            form.children('input[name="instrument_name"]').select();
                        }
                    });
                    return false;
                });
            });
            function edit_user(user_id) {
                $jq('#save').removeAttr('disabled');
                var url = "<?php echo site_url('user/edit_user'); ?>";
                $jq('#create_user')[0].reset();
                $jq.ajax({
                    type: "POST",
                    url: url,
                    data: "user_id=" + user_id,
                    dataType: "json",
                    success: edit_user_success(user_id)
                });

            }

            function edit_user_success(user_id) {
                return function(data) {
                    if (data.isSuccessful) {
                        $jq("#user_id").val(user_id);
                        $jq("#action").val("edit");
                        $jq("#first_name").val(data.user_info.first_name);
                        $jq("#middle_name").val(data.user_info.middle_name);
                        $jq("#last_name").val(data.user_info.last_name);
                        $jq("#dob").val(data.user_info.dob);
                        $jq("#email").val(data.user_info.email);
                        $jq('#email').attr('disabled', 'true');
                        $jq('#password').attr('placeholder', 'Enter a new Password');
                        $jq('#confirm_password').attr('placeholder', 'Enter again to Confirm');
                        $jq("#mobile_number").val(data.user_info.mobile);
                        $jq("#alternate_number").val(data.user_info.alternate_number);
                        $jq("#street1").val(data.user_info.street1);
                        $jq("#street2").val(data.user_info.street2);
                        $jq("#city").val(data.user_info.city);
                        $jq("#state").val(data.user_info.state);
                        $jq("#zip").val(data.user_info.zip);
                        $jq("#country").val(data.user_info.country);
                        $jq("#address_id").val(data.user_info.address_id);
                        if (data.user_info.course_frequency_id) {
                            $jq("input[name=frequency][value=" + data.user_info.course_frequency_id + "]").attr('checked', 'checked');
                        }
                        if (data.other_details) {
                            $jq("#school").val(data.other_details.school);
                            $jq("#standard").val(data.other_details.standard);
                            $jq("#emergency_contact").val(data.other_details.emergency_contact);
                            $jq("#special_needs").val(data.other_details.special_needs);
                            $jq("#course_duration").val(data.other_details.course_duration);
                            $jq("#course_goals").val(data.other_details.course_goals);
                            $jq("#grades_completed").val(data.other_details.grades_completed);
                            $jq("#instrument_details").val(data.other_details.instrument_details);
                        }
                        for (i = 0; i < data.instrument_info.length; i++) {
                            $jq("input[type='checkbox'][value='" + data.instrument_info[i].instrument_id + "']").prop('checked', true);
                        }
                    } else {
                        alert(data.message);
                    }
                }
            }

            function reset_form() {
                $jq('#email').removeAttr('disabled');
                $jq("#action").val("add");
            }

            function delete_user(user_id) {
                var faction = "<?php echo site_url('user/delete_user'); ?>";
                var fdata = {};
                fdata.user_id = user_id;
                $jq.post(faction, fdata, function(rdata) {
                    var json = jQuery.parseJSON(rdata);

                    if (json.isSuccessful) {
                        $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                        $jq('div #img-loader img').addClass('Absolute-Center');
                        $jq.ajax({
                            url: '<?php echo site_url('user/add_users'); ?>',
                            type: 'POST',
                            success: function(output_string) {
                                $jq('#content').html(output_string);
                            }
                        });
                    } else {
                        alert(json.message);
                    }
                });
            }

            function edit_staff(user_id) {
                $jq('#save').removeAttr('disabled');
                var url = "<?php echo site_url('user/edit_staff'); ?>";
                $jq('#create_staff')[0].reset();
                $jq.ajax({
                    type: "POST",
                    url: url,
                    data: "user_id=" + user_id,
                    dataType: "json",
                    success: edit_staff_success(user_id)
                });
            }

            function edit_staff_success(user_id) {
                return function(data) {
                    if (data.isSuccessful) {
                        $jq("#staff_id").val(user_id);
                        $jq("#staff_action").val("edit");
                        $jq("#staff_first_name").val(data.staff_info.first_name);
                        $jq("#staff_middle_name").val(data.staff_info.middle_name);
                        $jq("#staff_last_name").val(data.staff_info.last_name);
                        $jq("#staff_email").val(data.staff_info.email);
                        $jq('#staff_email').attr('disabled', 'true');
                        $jq('#staff_password').attr('placeholder', 'Enter a new Password');
                        $jq('#staff_confirm_password').attr('placeholder', 'Enter again to Confirm');
                        if (data.staff_info.access_attendance == 1) {
                            $jq("input[type='checkbox'][value='attendance']").prop('checked', true);
                        }
                        if (data.staff_info.access_fees_receipt == 1) {
                            $jq("input[type='checkbox'][value='fee_recipt']").prop('checked', true);
                        }

                    } else {
                        alert(data.message);
                    }
                }
            }

            function delete_staff(user_id) {
                var faction = "<?php echo site_url('user/delete_user'); ?>";
                var fdata = {};
                fdata.user_id = user_id;
                $jq.post(faction, fdata, function(rdata) {
                    var json = jQuery.parseJSON(rdata);

                    if (json.isSuccessful) {
                        $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                        $jq('div #img-loader img').addClass('Absolute-Center');
                        $jq.ajax({
                            url: '<?php echo site_url('user/settings'); ?>',
                            type: 'POST',
                            success: function(output_string) {
                                $jq('#content').attr("style", 'display: none;');
                                $jq('#content').html(output_string);
                            }
                        });
                    } else {
                        alert(json.message);
                    }
                });
            }

            function edit_batch(batch_id) {
                $jq('#save').removeAttr('disabled');
                var url = "<?php echo site_url('user/edit_batch'); ?>";
                $jq('#create_batch')[0].reset();
                $jq.ajax({
                    type: "POST",
                    url: url,
                    data: "batch_id=" + batch_id,
                    dataType: "json",
                    success: edit_batch_success(batch_id)
                });
            }

            function edit_batch_success(batch_id) {
                return function(data) {
                    if (data.isSuccessful) {
                        $jq("#batch_id").val(batch_id);
                        $jq("#batch_action").val("edit");
                        $jq("#batch_name").val(data.batch_info.batch_name);
                        $jq("#batch_strength").val(data.batch_info.batch_strength);
                        $jq("#from_time").val(data.batch_info.from_time);
                        $jq("#to_time").val(data.batch_info.to_time);
                        for (i = 0; i < data.batch_days.length; i++) {
                            $jq("input[type='checkbox'][value='" + data.batch_days[i].day_id + "']").prop('checked', true);
                        }

                    } else {
                        alert(data.message);
                    }
                }
            }

            function delete_batch(batch_id) {
                var faction = "<?php echo site_url('user/delete_batch'); ?>";
                var fdata = {};
                fdata.batch_id = batch_id;
                $jq.post(faction, fdata, function(rdata) {
                    var json = jQuery.parseJSON(rdata);

                    if (json.isSuccessful) {
                        $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                        $jq('div #img-loader img').addClass('Absolute-Center');
                        $jq.ajax({
                            url: '<?php echo site_url('user/batch'); ?>',
                            type: 'POST',
                            success: function(output_string) {
                                $jq('#content').attr("style", 'display: none;');
                                $jq('#content').html(output_string);
                            }
                        });
                    } else {
                        alert(json.message);
                    }
                });
            }

            function edit_instrument(instrument_id) {
                $jq('#save').removeAttr('disabled');
                var url = "<?php echo site_url('user/edit_instrument'); ?>";
                $jq('#create_instrument')[0].reset();
                $jq.ajax({
                    type: "POST",
                    url: url,
                    data: "instrument_id=" + instrument_id,
                    dataType: "json",
                    success: edit_instrument_success(instrument_id)
                });
            }

            function edit_instrument_success(instrument_id) {
                return function(data) {
                    if (data.isSuccessful) {
                        $jq("#instrument_id").val(instrument_id);
                        $jq("#instrument_action").val("edit");
                        $jq("#instrument_name").val(data.instrument_info.instrument_name);
                    } else {
                        alert(data.message);
                    }
                }
            }

            function delete_instrument(instrument_id) {
                var faction = "<?php echo site_url('user/delete_instrument'); ?>";
                var fdata = {};
                fdata.instrument_id = instrument_id;
                $jq.post(faction, fdata, function(rdata) {
                    var json = jQuery.parseJSON(rdata);

                    if (json.isSuccessful) {
                        $jq('div#img-loader').append('<img src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                        $jq('div #img-loader img').addClass('Absolute-Center');
                        $jq.ajax({
                            url: '<?php echo site_url('user/instruments'); ?>',
                            type: 'POST',
                            success: function(output_string) {
                                $jq('#content').attr("style", 'display: none;');
                                $jq('#content').html(output_string);
                            }
                        });
                    } else {
                        alert(json.message);
                    }
                });
            }


            function edit_fee_receipt(fee_receipt_id) {
                $jq('#save').removeAttr('disabled');
                var url = "<?php echo site_url('user/edit_fee_receipt'); ?>";
                $jq('#create_fee_receipt')[0].reset();
                $jq.ajax({
                    type: "POST",
                    url: url,
                    data: "fee_receipt_id=" + fee_receipt_id,
                    dataType: "json",
                    success: edit_fee_receipt_success(fee_receipt_id)
                });
            }

            function edit_fee_receipt_success(fee_receipt_id) {
                return function(data) {
                    if (data.isSuccessful) {
                        $jq("#fee_receipt_id").val(fee_receipt_id);
                        $jq("#fee_receipt_action").val("edit");
                        $jq("#name").val(data.fee_receipt_info.users_user_id);
                        $jq("#date").val(data.fee_receipt_info.receipt_date);
                        $jq("#description").val(data.fee_receipt_info.description);
                        $jq("#amount").val(data.fee_receipt_info.amount);
                        $jq("#amount_paid").val(data.fee_receipt_info.amount_paid);
                        $jq("#particulars").val(data.fee_receipt_info.particulars);
//                        if (data.fee_receipt_info.fee_status_id) {
//                            $jq("input[name=fee_status_id][value=" + data.fee_receipt_info.fee_status_id + "]").attr('checked', 'checked');
//                        }
                    } else {
                        alert(data.message);
                    }
                }
            }
            function get_users() {
                var attendance_schedule_id = $jq('#attendance_schedule_id').val();
                $jq.ajax({
                    url: '<?php echo site_url('user/attendance_register'); ?>',
                    type: 'POST',
                    data: "attendance_schedule_id=" + attendance_schedule_id,
                    success: function(output_string) {
                        $jq('#content').html(output_string);
                        $jq("#attendance_schedule_id").val(attendance_schedule_id);
                    }
                });
            }
            function get_attendance_report() {
                var schedule_id = $jq('#batch_name').val();
                $jq.ajax({
                    url: '<?php echo site_url('user/attendance'); ?>',
                    type: 'POST',
                    data: "batch_name=" + schedule_id,
                    success: function(output_string) {
                        $jq('#content').html(output_string);
                        $jq("#batch_name").val(schedule_id);
                    }
                });
            }
        </script>
        <style type="text/css">
            .Absolute-Center {  
                overflow: auto;
                margin: auto;
                position: absolute;
                /*top: 240px; left: 0; bottom: 0; right: 0;*/
                top: 0; left: 0; bottom: 0; right: 0;
                height:100px;
                width:100px;
            }
        </style>