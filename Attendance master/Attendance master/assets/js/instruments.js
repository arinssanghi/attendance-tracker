//validation page for add_users.php
$au = jQuery.noConflict();
$au(document).ready(function() {

//For validating a form you have to specify the rules and their respective messages form form fileds.
//In this case create_batch is the id of the form and rest are form field names.  
    $au("#create_instrument").validate({
        debug: true,
        errorElement: "em",
        rules: {
            instrument_name: {
                required: true
            }
        },
        errorPlacement: function(error, element) {
            error.insertBefore(element);
        },
        messages: {
            instrument_name: {
                required: "Enter Instrument Name<br />"
            }
        }
    });
});