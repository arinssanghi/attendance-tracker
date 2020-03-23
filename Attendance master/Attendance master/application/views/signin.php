<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>


        <!-- General meta information -->
        <title>Login</title>
        <meta charset="utf-8" />
        <link rel="shortcut icon" href="<?php echo base_url('assets/ico/favicon.ico'); ?>">
            <!-- Load Javascript -->
            <script type="text/javascript" src="<?php echo base_url('assets/xhtml/js/jquery.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/xhtml/js/jquery.query-2.1.7.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/xhtml/js/rainbows.js'); ?>"></script>
            <!-- // Load Javascipt -->

            <!-- Load stylesheets -->
            <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/xhtml/css/style.css'); ?>" media="screen" />
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
            <!-- // Load stylesheets -->
            <script type="text/javascript">
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
            <div id="wrappermiddle">
                <h2>Login</h2>
                <form id="loginForm">
                    <div id="username_input">
                        <div id="username_inputleft"></div>
                        <div id="username_inputmiddle">
                            <input type="text" name="email" id="url" value="" placeholder="Email Address" />
                            <img id="url_user" src="<?php echo base_url('assets/xhtml/images/mailicon.png'); ?>" alt="" />
                        </div>
                        <div id="username_inputright"></div>
                    </div>
                    <div id="password_input">
                        <div id="password_inputleft"></div>
                        <div id="password_inputmiddle">
                            <input type="password" name="password" id="url" placeholder="Password" value="" />
                            <img id="url_password" src="<?php echo base_url('assets/xhtml/images/passicon.png'); ?>" alt="" />
                        </div>
                        <div id="password_inputright"></div>
                    </div>
                    <div id="submit">
                        <input type="image" src="<?php echo base_url('assets/xhtml/images/submit_hover.png'); ?>" id="submit1" value="Sign In" />
                        <input type="image" src="<?php echo base_url('assets/xhtml/images/submit.png'); ?>" id="submit2" value="Sign In" />
                    </div>
                </form>
                <div id="links_left">
                    <a href="<?php echo site_url('signin/forgot_password'); ?>">Forgot your Password?</a>
                </div>
                <br />
                <div style="clear: both;"></div>
                <div style="width: 20px; float: left;"></div>
                <div id="error" style="display: none;float: left; padding-left: 81px; padding-right:59px; padding-top: 5px;">
                    <div>
                        <div id="errorMessage" class="error"></div>
                    </div>
                </div>
            </div>
            <div id="wrapperbottom"></div>
        </div>
        <script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#login-submit').removeAttr('disabled');
                $('#loginForm').submit(function() {
                    $('#login-submit').attr('disabled', 'true');
                    $('#wrappermiddle').css("height", 240);
                    var form = $(this);
                    $('#error').hide();
                    var faction = "<?php echo site_url('signin/is_valid_user'); ?>";
                    var fdata = form.serialize();

                    $.post(faction, fdata, function(rdata) {

                        var json = jQuery.parseJSON(rdata);

                        if (json.isSuccessful) {
                            window.location = json.message.url;
                        } else {
                            var error_message = json.message.message;
                            if (error_message.length > 70 && error_message.length < 80) {
                                $('#error').css("padding-left", 77);
                                $('#wrappermiddle').css("height", 326);
                            } else if (error_message.length > 25 && error_message.length < 40) {
                                $('#error').css("padding-left", 72);
                                $('#wrappermiddle').css("height", 300);
                            } else if (error_message.length > 90) {
                                $('#error').css("padding-left", 77);
                                $('#error').css("padding-right", 77);
                                $('#wrappermiddle').css("height", 326);
                            } else if (error_message.length <= 25) {
                                $('#error').css("padding-left", 82);
                                $('#wrappermiddle').css("height", 300);
                            }
                            $('#login-submit').removeAttr('disabled');

                            $('#errorMessage').html(json.message.message);
                            $('#error').show();
                            form.children('input[name="email"]').select();
                        }
                    });
                    return false;
                    $('#login-submit').removeAttr('disabled');
                });
            });
        </script>
    </body>
</html>