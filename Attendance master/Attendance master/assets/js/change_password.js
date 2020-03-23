//validation page for add_users.php
$au = jQuery.noConflict();
$au(document).ready(function() {

//For validating a form you have to specify the rules and their respective messages form form fileds.
//In this case change_password is the id of the form and rest are form field names.  
    $au("#change_password").validate({
        debug: true,
        errorElement: "em",
        rules: {
            current_password: {
                required: true,
            },
            new_password: {
                required: true,
                minlength: 5,
            },
            confirm_new_password: {
                required: true,
                minlength: 5,
                equalTo: "#new_password"
            }
        },
        errorPlacement: function(error, element) {
            error.insertBefore(element);
        },
        messages: {
            current_password: {
                required: "Enter Current Password<br />"
            },
            new_password: {
                required: "Enter New Password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_new_password: {
                required: "Confirm New Password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            }
        }
    });
});