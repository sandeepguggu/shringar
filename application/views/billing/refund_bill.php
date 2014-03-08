<style>
.box {
	width:100%;
}
.left {
	float:left;
}
.right {
	float:right;
}
.clr {
	clear:both;
}
.b {
	font-weight:bold;
}
.mt_10 {
	margin-top:10px;
}
.mt_20 {
	margin-top:20px;
}
.ui-autocomplete-loading {
	background: white url('/resources/css/images/ui-anim_basic_16x16.gif') right center no-repeat;
}
.exchange-item {
    background: red;
    color: whitesmoke;
}
</style>

<script type="text/javascript">
    $(document).ready(function(){
        $("#refund").click(function() {
            var url = location.href;
            url = url.replace('refund', 'confirm_refund');
            window.open(url,'_self');
        });
    });
</script>

<h3>Confirm and Refund</h3>
<hr />
<br />

<div class="box mt_20">
    <div style="width:100%; float:left;">
        <table>
            <tr>
                <td>First Name</td>
                <td><?php echo $c['fname']; ?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?php echo $c['lname']; ?></td>
            </tr>

            <tr>
                <td>Phone/Mobile</td>
                <td><?php echo $c['phone'];?></td>
            </tr>
            <tr>
                <td>SMS</td>
                <td><?php echo $c['sms']; ?></td>
            </tr>
            <tr>
                <td>Sex</td>
                <td><?php echo $c['sex']; ?></td>
            </tr>
            <tr>
                <td>Date of Birth</td>
                <td><?php echo $c['dob']; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo $c['email']; ?></td>
            </tr>
                <tr>
                <td>Building</td>
                <td><?php echo $c['building']; ?></td>
            </tr>
                <tr>
                <td>Street</td>
                <td><?php echo $c['street']; ?></td>
            </tr>

                <tr>
                <td>Area</td>
                <td><?php echo $c['area']; ?></td>
            </tr>

            <tr>
                <td>City</td>
                <td><?php echo $c['city']; ?></td>
            </tr>
            <tr>
                <td>Pin</td>
                <td><?php echo $c['pin']; ?></td>
            </tr>

            <tr>
                <td>State</td>
                <td><?php echo $c['state']; ?></td>
            </tr>
        </table>
    </div>
</div>

<br class="clr" />

<div class="box mt_20">
    <div class="items">
        <table width="100%" id="product_table">
            <tr>
                <th>Sl No</th>
                <th>Product ID</th>
                <th>Price</th>
                <th>Vat(%)</th>
                <th>Total</th>
            </tr>

            <?php echo $products; ?>

            <tr id="product_table_total">
                <td colspan="6">Refund Amount</td>
                <td id="product_table_total_amount"><?php echo $product_total_amount; ?></td>
            </tr>

            <tr>
                <td colspan="6">
                    Discount Type : <?php echo $discount_option; ?>
                    <br />
                    Discount Value : <?php echo $discount_value; ?><br />
                </td>
                <td id="product_table_final_amount"><?php echo $pay_amount;?></td>
            </tr>
        </table>
        <input id="refund" type="button" value="Refund" class="btn primary large" /> &nbsp;
        <a onclick="if(!confirm('Are you sure?')) return false;" class="btn danger large" href="<?php echo site_url('billing/exchange'); ?>">Cancel</a>
    </div>
</div>