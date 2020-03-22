//validation page for add_users.php
$au = jQuery.noConflict();
$au(document).ready(function() {

//For validating a form you have to specify the rules and their respective messages form form fileds.
//In this case locreate_userginForm is the id of the form and rest are form field names.  
    $au("#create_user").validate({
        debug: true,
        errorElement: "em",
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            dob: {
                required: true
            },
            email: {
                required: true
            },
            password: {
                required: true,
                minlength: 5,
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            }
        },
        errorPlacement: function(error, element) {
            error.insertBefore(element);
        },
        messages: {
            first_name: {
                required: "Enter First Name<br />"
            },
            last_name: {
                required: "Enter Last Name<br />"
            },
            dob: {
                required: "Select Date of Birth<br />"
            },
            email: {
                required: "Enter Email<br />"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Enter Confirm Password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            }
        }
    });
});