//validation page for add_users.php
$au = jQuery.noConflict();
$au(document).ready(function() {

//For validating a form you have to specify the rules and their respective messages form form fileds.
//In this case create_batch is the id of the form and rest are form field names.  
    $au("#create_batch").validate({
        debug: true,
        errorElement: "em",
        rules: {
            batch_name: {
                required: true
            },
            batch_strength: {
                required: true
            },
            from_time: {
                required: true
            },
            to_time: {
                required: true
            }
        },
        errorPlacement: function(error, element) {
            error.insertBefore(element);
        },
        messages: {
            batch_name: {
                required: "Enter Batch Name<br />"
            },
            batch_strength: {
                required: "Enter Batch strength<br />"
            },
            from_time: {
                required: "Enter From Time<br />"
            },
            to_time: {
                required: "Enter To Time"
            }
        }
    });
});