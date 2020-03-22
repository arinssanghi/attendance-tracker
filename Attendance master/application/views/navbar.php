<body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="cursor: pointer;">Attendance System</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php if ($role == md5(1)) { ?>
                        <li><a style="cursor: pointer;" onclick="show_settings();">Staffs</a></li>
                    <?php } ?>
                    <li><a style="cursor: pointer;" onclick="change_password();">Change Password</a></li>
                    <li><a href="<?php echo site_url('signout'); ?>">Log Out</a></li>
                </ul>
                <!--                <form class="navbar-form navbar-right">
                                    <input class="form-control" placeholder="Search..." type="text">
                                </form>-->
            </div>
        </div>
    </div>
    <script type="text/javascript">
                        var stateObj = {foo: "bar"};
                        function change_password() {
                            $jq(".ui-datepicker").remove();
                            $jq(".row div ul li").each(function(index, element) {
                                if ($jq(element).hasClass("active")) {
                                    $jq(element).removeClass('active');
                                }
                            });
                            $jq('#content').html('');
                            $jq('div#img-loader').append('<img id="image-loader" src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                            $jq('div #img-loader img').addClass('Absolute-Center');
                            $jq.ajax({
                                url: '<?php echo site_url('user/change_password'); ?>',
                                type: 'POST',
                                success: function(output_string) {
                                    // here you need to inject the new data in the page 
                                    // in place of the old data
                                    history.pushState(stateObj, "", "<?php echo site_url('user/change_password'); ?>");
                                    $jq('#content').attr("style", 'display: none;');
                                    $jq('#content').html(output_string);

                                }
                            });
                        }
                        function show_settings() {
                            $jq('#content').html('');
                            $jq(".ui-datepicker").remove();
                            $jq(".row div ul li").each(function(index, element) {
                                if ($jq(element).hasClass("active")) {
                                    $jq(element).removeClass('active');
                                }
                            });
                            $jq('div#img-loader').append('<img id="image-loader" src="<?php echo base_url("assets/img/ajax-loader.gif"); ?>"></img>');
                            $jq('div #img-loader img').addClass('Absolute-Center');
                            $jq.ajax({
                                url: '<?php echo site_url('user/settings'); ?>',
                                type: 'POST',
                                success: function(output_string) {
                                    // here you need to inject the new data in the page 
                                    // in place of the old data
                                    history.pushState(stateObj, "", "<?php echo site_url('user/settings'); ?>");
                                    $jq('#content').attr("style", 'display: none;');
                                    $jq('#content').html(output_string);

                                }
                            });
                        }
    </script>