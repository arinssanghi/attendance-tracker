//validation page for signin.php
$(document).ready(function() {

//For validating a form you have to specify the rules and their respective messages form form fileds.
//In this case loginForm is the id of the form and rest are form field names.  
    $("#loginForm").validate({
        debug: true,
        errorElement: "em",
        rules: {
            email: {
                required: true
            },
            password: {
                required: true
            }
        },
        errorPlacement: function(error, element) {
            error.insertBefore(element);
        },
        messages: {
            email: {
                required: "Please enter the Email<br />"
            },
            password: {
                required: "Please enter the Password"
            }
        }
    });
});