//validation page for add_users.php
$au = jQuery.noConflict();
$au(document).ready(function() {

//For validating a form you have to specify the rules and their respective messages form form fileds.
//In this case create_batch is the id of the form and rest are form field names.  
    $au("#create_fee_receipt").validate({
        debug: true,
        errorElement: "em",
        rules: {
            name: {
                required: true
            },
            date: {
                required: true
            },
            description: {
                required: true
            },
            amount: {
                required: true
            },
            particulars: {
                required: true
            }
        },
        errorPlacement: function(error, element) {
            error.insertBefore(element);
        },
        messages: {
            name: {
                required: "Select Name<br />"
            },
            date: {
                required: "Select a date<br />"
            },
            description: {
                required: "Enter description<br />"
            },
            amount: {
                required: "Enter the amount"
            },
            particulars: {
                required: "Enter the particulars"
            }
        }
    });
});