<?php
if (!$isAjax) {
    echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="content">';
}
?>
<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/less/datepicker.less'); ?>" rel="stylesheet">
<!-- Include JQuery UI (Required for calendar plugin.) -->
<script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
    $dp = jQuery.noConflict();
    $dp(function() {
        $dp('#date').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>
<style type="text/css">
    .error {
        color: #D8000C;
    }
</style>
<h1 class="page-header">Fee Receipts</h1>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <!--<th>#</th>-->
                <th>Name</th>
                <th>Date</th>
                <th>Description</th>
                <th>Total Amount</th>
                <th>Amount Paid</th>
                <th>Balance</th>
                <th>Particulars</th>
                
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($fee_receipts) {
                foreach ($fee_receipts as $fee_receipt) {
                    ?>
                    <tr>
                        <td><?php echo $fee_receipt['first_name'] . ' ' . $fee_receipt['last_name']; ?></td>
                        <td><?php echo $fee_receipt['receipt_date']; ?></td>
                        <td><?php echo $fee_receipt['description']; ?></td>
                        <td>&#8377;&nbsp;<?php echo $fee_receipt['amount']; ?></td>
                        <td>&#8377;&nbsp;<?php echo $fee_receipt['amount_paid']; ?></td>
                        <td>&#8377;&nbsp;<?php echo round($fee_receipt['amount']-$fee_receipt['amount_paid'],2); ?></td>
                        <td><?php echo $fee_receipt['particulars']; ?></td>
                        <td><a style="cursor: pointer" onclick="edit_fee_receipt(<?php echo $fee_receipt['fee_receipt_id']; ?>)">Edit</a>&nbsp;&nbsp;<a style="cursor: pointer" onclick="delete_fee_receipt(<?php echo $fee_receipt['fee_receipt_id']; ?>)">Delete</a></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

<div class="widget widget-2 widget-body-white">
    <div class="widget-body">
        <form class="form-horizontal" id="create_fee_receipt" method="post" autocomplete="off">
            <fieldset>

                <!-- Form Name -->
                <legend>Create a Fee Receipt</legend>
                <div class="row-fluid">
                    <div class="span6">
                        <!-- Select Basic -->
                        <div class="control-group users">
                            <label class="control-label" for="name">Name</label>
                            <div class="controls">
                                <select id="name" name="name" class="span12" onchange="alert(this.value);">
                                    <?php
                                    if ($users) {
                                        foreach ($users as $user) {
                                            echo "<option value='" . $user['users_user_id'] . "'>" . $user['first_name'] . " " . substr($user['middle_name'], 0, 1) . " " . $user['last_name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="date">Date</label>
                            <div class="controls"><input id="date" name="date" class="input-small" placeholder="Date" type="text" /></div>
                        </div>
                        <!-- Textarea -->
                        <div class="control-group">
                            <label class="control-label" for="description">Description</label>
                            <div class="controls">                     
                                <textarea id="description" class="span12" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <!-- Text input-->
                        <div class="control-group">
                            <label class="control-label" for="amount">Total Amount&nbsp;(&#8377;)</label>
                            <div class="controls">
                                <input id="amount" class="span12" name="amount" placeholder="Amount" type="text">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="amount_paid">Amount Paid&nbsp;(&#8377;)</label>
                            <div class="controls">
                                <input id="amount_paid" class="span12" name="amount_paid" placeholder="Amount Paid" type="text">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="particulars">Particulars</label>
                            <div class="controls">
                                <!--<input class="span12" id="particulars" name="particulars" placeholder="Particulars" type="text" />-->
                                <textarea id="particulars" class="span12" name="particulars"></textarea>
                            </div>
                        </div>
<!--                        <div class="control-group">
                            <label class="control-label" for="fee_status_id">Fee Status</label>
                            <div class="controls">
                                <label class="radio" for="paid">
                                    <input name="fee_status_id" id="paid" value="1" checked="checked" type="radio">
                                    Paid
                                </label>
                                <label class="radio" for="unpaid">
                                    <input name="fee_status_id" id="unpaid" value="2" type="radio">
                                    Unpaid
                                </label>
                            </div>
                        </div>-->
                        <input type="hidden" value="add" name="fee_receipt_action" id="fee_receipt_action" />
                        <input type="hidden" value="" name="fee_receipt_id" id="fee_receipt_id" />
                        <!-- Button (Double) -->
                        <div class="control-group">
                            <label class="control-label" for="save"></label>
                            <div class="controls">
                                <button id="save" name="save" class="btn btn-primary">Save</button>
                                <button id="cancel" name="cancel" type="reset" class="btn btn-inverse">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script src="<?php echo base_url("assets/js/jquery.validate.js"); ?>"></script>
<script src="<?php echo base_url('assets/js/fee_receipts.js'); ?>"></script>
<script type="text/javascript">
    $wl = jQuery.noConflict();
    $wl(document).ready(function(){
        $wl('#content').show();
        $wl('div #img-loader img').remove();
   });
</script>
<?php
if (!$isAjax) {
    ?>
    </div>
    </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/docs.js'); ?>"></script>

    </body>
    </html>
    <?php
}
?>