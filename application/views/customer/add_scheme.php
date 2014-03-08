<script>
    $(function(){
        $('#customer_dob').datepicker();
        $('#frm_add_customer').validate({
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: form.action,
                    data: $(form).serialize(),
                    success: function (data, textStatus, jqXHR) {
                        $.fancybox.close();
                    }
                });
                return false;
            }
        });
    });
</script>
<?php
if (isset($success)) {
    echo '<div class="alert-message success">' . $success . '</div>';
}
if (isset($failed)) {
    echo '<div class="alert-message danger">' . $failed . '</div>';
}
?>
<span class="span16"><strong>New Scheme</strong></span> <br /><br />
<form action="<?php echo site_url('scheme/add_to_db'); ?>" method="post" id="frm_add_customer" onsubmit="return false;">
    <table class="bordered-table" style="width:100%;">
        <tr>
            <td width="20%">Name</td>
            <td><input class="required" maxlength="25" type="text" name="name" id="input_customer_name"  /></td>
        </tr>
        <tr>
            <td>Min Installment</td>
            <td><input class="required" maxlength="25" type="text" name="min_installment" /></td>
        </tr>
        <tr>
            <td>Terms</td>
            <td><input class="required digits" type="text" name="terms" id="input_customer_mobile" /></td>
        </tr>
        <tr>
            <td>Duration</td>
            <td><input class="required digits" type="text" name="duration_months" id="input_customer_mobile" /></td>
        </tr>
         <tr>
            <td>Adv Type</td>
            <td><input class="required digits" type="text" name="adv_type" id="input_customer_mobile" /></td>
        </tr>
         <tr>
            <td>Flexible</td>
            <td><input class="required digits" type="text" name="flexible" id="input_customer_mobile" /></td>
        </tr>
         <tr>
            <td>Bonus Installments</td>
            <td><input class="required digits" type="text" name="bonus_installments" id="input_customer_mobile" /></td>
        </tr>
         <tr>
            <td>MCD</td>
            <td><input class="required digits" type="text" name="making_cost_disc" id="input_customer_mobile" /></td>
        </tr>
         <tr>
            <td>LIMIT(MCD)</td>
            <td><input class="required digits" type="text" name="making_cost_disc_limit" id="input_customer_mobile" /></td>
        </tr>
         <tr>
            <td>WCD</td>
            <td><input class="required digits" type="text" name="wastage_cost_disc" id="input_customer_mobile" /></td>
        </tr>
         <tr>
            <td>LIMIT(WCD)</td>
            <td><input class="required digits" type="text" name="wastage_cost_disc_limit" id="input_customer_mobile" /></td>
        </tr>
         <tr>
            <td>Vat Discnt.</td>
            <td><input class="required digits" type="text" name="vat_discount" id="input_customer_mobile" /></td>
        </tr>
         <tr>
            <td>Vat Discnt. limit</td>
            <td><input class="required digits" type="text" name="vat_discount_limit" id="input_customer_mobile" /></td>
        </tr>
         <tr>
            <td>Referal Bonus</td>
            <td><input class="required digits" type="text" name="referal_bonus_percent" id="input_customer_mobile" /></td>
        </tr>
         <tr>
            <td>Comments</td>
            <td><input class="required digits" type="text" name="Comments" id="input_customer_mobile" /></td>
        </tr>
    </table>
    <input type="submit" class="btn primary" value="Add Scheme"/>
    <input type="button" class="btn danger" value="Cancel" onclick="$.fancybox.close();" />
</form>
