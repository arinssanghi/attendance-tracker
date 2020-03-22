<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>


        <!-- General meta information -->
        <title>Forgot Password</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="robots" content="index, follow" />
        <meta charset="utf-8" />
        <link rel="shortcut icon" href="<?php echo base_url('assets/ico/favicon.ico'); ?>">
            <!-- // General meta information -->


            <!-- Load Javascript -->
            <script type="text/javascript" src="<?php echo base_url('assets/xhtml/js/jquery.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/xhtml/js/jquery.query-2.1.7.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/xhtml/js/rainbows.js'); ?>"></script>
            <!-- // Load Javascipt -->

            <!-- Load stylesheets -->
            <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/xhtml/css/style.css'); ?>" media="screen" />
            <!-- // Load stylesheets -->
            <style type="text/css">
                .info, .success, .warning, .error {
                    border: 1px solid;
                    margin: 10px 0px;
                    padding:15px 10px;
                    background-repeat: no-repeat;
                    background-position: 10px center;-moz-border-radius:.5em;
                    -webkit-border-radius:.5em;
                    border-radius:.5em;

                }
                .info {
                    color: #00529B;
                    background-color: #BDE5F8;
                }
                .success {
                    color: #4F8A10;
                    background-color: #DFF2BF;
                }
                .warning {
                    color: #9F6000;
                    background-color: #FEEFB3;
                }
                .error {
                    color: #D8000C;
                    background-color: #FFBABA;
                }
            </style>
            <script>


                $(document).ready(function() {

                    $("#submit1").hover(
                            function() {
                                $(this).animate({"opacity": "0"}, "slow");
                            },
                            function() {
                                $(this).animate({"opacity": "1"}, "slow");
                            });
                });


            </script>

    </head>
    <body>

        <div id="wrapper">
            <div id="wrappertop"></div>

            <div id="wrappermiddle" style="height: 192px !important;">

                <h2>Forgot Password</h2>
                <form id="forgot_password">
                    <div id="username_input">

                        <div id="username_inputleft"></div>

                        <div id="username_inputmiddle">
                            <input type="text" name="email" id="url" value="" placeholder="Email Address" />
                            <img id="url_user" src="<?php echo base_url('assets/xhtml/images/mailicon.png'); ?>" alt="" />
                        </div>

                        <div id="username_inputright"></div>
                    </div>
                    <div id="submit" style="margin-top: 120px !important;">
                        <input type="image" src="<?php echo base_url('assets/xhtml/images/forgot_password_hover.png'); ?>" id="submit1" value="Sign In" />
                        <input type="image" src="<?php echo base_url('assets/xhtml/images/forgot_password.png'); ?>" id="submit2" value="Sign In" />
                    </div>
                </form>
                <div id="links_left">

                    <a href="<?php echo site_url('signin'); ?>">Back to Login</a>
                </div>

                <div style="clear: both;"></div>
                <div id="error" style="display: none; float: left; padding-left: 85px; padding-right:50px; padding-top: 5px;">
                    <div>
                        <div id="errorMessage" class="error"></div>
                    </div>
                </div>
                <div id="success" style="display: none; float: left; padding-left: 52px; padding-right:50px; padding-top: 5px;">
                    <div>
                        <div id="successMessage" class="success"></div>
                    </div>
                </div>
            </div>

            <div id="wrapperbottom"></div>
        </div>
        <script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#forgot_password').submit(function() {
                    $('#submit1').attr('disabled', 'true');
                    $('#submit2').attr('disabled', 'true');
                    var form = $(this);
                    $('#error').hide();
                    $('#success').hide();
                    $('#successMessage').html('');
                    var faction = "<?php echo site_url('signin/send_reset_password_link'); ?>";
                    var fdata = form.serialize();
                    $('#wrappermiddle').css("height", 192);
                    $.post(faction, fdata, function(rdata) {

                        var json = jQuery.parseJSON(rdata);

                        if (json.isSuccessful) {
                            $('#submit1').removeAttr('disabled');
                            $('#submit2').removeAttr('disabled');
                            $('#wrappermiddle').css("height", 300);
                            $('#successMessage').html(json.message + "<b>" + json.email + "</b>");
                            $('#success').show();
                        } else {
                            $('#submit1').removeAttr('disabled');
                            $('#submit2').removeAttr('disabled');
                            $('#errorMessage').html(json.message);
                            if (json.message.length == 36) {
                                $('#wrappermiddle').css("height", 265);
                                $('#error').css("padding-left", 85);
                                $('#error').css("padding-right", 62);
                            } else if (json.message.length == 38) {
                                $('#wrappermiddle').css("height", 276);
                                $('#error').css("padding-left", 64);
                                $('#error').css("padding-right", 62);
                            }
//                            
                            $('#error').show();
                            form.children('input[name="email"]').select();
                        }
                    });
                    return false;
                    $('#submit1').removeAttr('disabled');
                    $('#submit2').removeAttr('disabled');
                });
            });
        </script>
        <script src="<?php echo base_url("assets/js/jquery.validate.js"); ?>"></script>
    </body>
</html>