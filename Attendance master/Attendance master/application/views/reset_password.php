<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>


        <!-- General meta information -->
        <title>Reset Password</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="robots" content="index, follow" />
        <meta charset="utf-8" />
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

            <div id="wrappermiddle" style="height: 286px !important;">

                <h2>Reset Password</h2>
                <form id="reset_password">
                    <div id="username_input">
                        <div id="username_inputleft"></div>
                        <div id="username_inputmiddle">
                            <input type="text" name="email" id="url" value="<?php echo $email; ?>" disabled="disabled" placeholder="Email Address" />
                            <img id="url_user" src="<?php echo base_url('assets/xhtml/images/mailicon.png'); ?>" alt="" />
                            <input type="hidden" name="user_email" value="<?php echo $email; ?>" />
                        </div>
                        <div id="username_inputright"></div>
                    </div>
                    <div id="password_input">
                        <div id="password_inputleft"></div>
                        <div id="password_inputmiddle">
                            <input type="password" name="password" id="url" placeholder="New Password" value="" />
                            <img id="url_password" src="<?php echo base_url('assets/xhtml/images/passicon.png'); ?>" alt="" />
                        </div>
                        <div id="password_inputright"></div>
                    </div>
                    <div id="confirm_password_input">
                        <div id="confirm_password_inputleft"></div>
                        <div id="confirm_password_inputmiddle">
                            <input type="password" name="confirm_password" id="url" placeholder="Confirm Password" value="" />
                            <img id="confirm_url_password" src="<?php echo base_url('assets/xhtml/images/passicon.png'); ?>" alt="" />
                        </div>
                        <div id="confirm_password_inputright"></div>
                    </div>
                    <div id="submit" style="margin-top: 227px !important;">
                        <input type="image" src="<?php echo base_url('assets/xhtml/images/forgot_password_hover.png'); ?>" id="submit1" value="Sign In" />
                        <input type="image" src="<?php echo base_url('assets/xhtml/images/forgot_password.png'); ?>" id="submit2" value="Sign In" />
                    </div>
                </form>
                <div id="links_left">

                    <a href="<?php echo site_url('signin'); ?>">Back to Login</a>
                </div>

                <div style="clear: both;"></div>
                <div style="width: 20px; float: left;"></div>
                <div id="error" style="display: none;float: left; padding-left: 85px; padding-right:50px; padding-top: 5px;">
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
<?php if ($error) {
    ?>
                    $('#wrappermiddle').css("height", 358);
                    $('#errorMessage').html('<?php echo $error; ?>');
                    $('#error').show();
    <?php
}
?>
                $('#reset_password').submit(function() {
                    $('#submit1').attr('disabled', 'true');
                    $('#submit2').attr('disabled', 'true');
                    var form = $(this);
                    $('#error').hide();
                    var faction = "<?php echo site_url('signin/update_password'); ?>";
                    var fdata = form.serialize();
                    $('#wrappermiddle').css("height", 286);
                    $.post(faction, fdata, function(rdata) {

                        var json = jQuery.parseJSON(rdata);

                        if (json.isSuccessful) {
//                            alert(json.message);
                            window.location = json.message.url;
                        } else {
                            $('#submit1').removeAttr('disabled');
                            $('#submit2').removeAttr('disabled');
                            $('#wrappermiddle').css("height", 418);
//                            $('#error').css("padding-right", 85);
                            $('#errorMessage').html(json.message);
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