//validation page for add_users.php
$au = jQuery.noConflict();
$au(document).ready(function() {

//For validating a form you have to specify the rules and their respective messages form form fileds.
//In this case create_staff is the id of the form and rest are form field names.  
    $au("#create_staff").validate({
        debug: true,
        errorElement: "em",
        rules: {
            staff_first_name: {
                required: true
            },
            staff_last_name: {
                required: true
            },
            staff_email: {
                required: true
            },
            staff_password: {
                required: true,
                minlength: 5,
            },
            staff_confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#staff_password"
            }
        },
        errorPlacement: function(error, element) {
            error.insertBefore(element);
        },
        messages: {
            staff_first_name: {
                required: "Enter First Name<br />"
            },
            staff_last_name: {
                required: "Enter Last Name<br />"
            },
            staff_email: {
                required: "Enter Email<br />"
            },
            staff_password: {
                required: "Enter Password",
                minlength: "Your password must be at least 5 characters long"
            },
            staff_confirm_password: {
                required: "Enter Confirm Password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            }
        }
    });
});