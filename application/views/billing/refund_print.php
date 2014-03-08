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

<script>
    $(function() {
        $("#exchange_now").click(function() {
            var url = '/index.php/billing/invoice/'+$("#credit_note_id").val();
            window.open(url, '_SELF');
        });
    });
</script>

<h3>Credit Note</h3>
<hr />
<br />

<?php if($success == 0): ?>
    <div>
        Status:&nbsp;
        <b>Failed</b>
    </div>
<?php else :?>
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

                <tr>
                    <td>Credit Note</td>
                    <td><?php echo $credit_note; ?></td>
                </tr>

                <tr>
                    <td>Refund Amount</td>
                    <td><?php echo $refund_amount; ?></td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td><?php echo $status; ?></td>
                </tr>

                <tr>
                    <td>Bill ID</td>
                    <td><?php echo $bill_id; ?></td>
                </tr>

            </table>
            <br />
            <input type="hidden" id="credit_note_id" value="<?php echo $credit_note;?>"/>
            <input type="button" class="btn primary large" id="exchange_now" value="Exchange Now"/>
            <input type="button" class="btn primary large" id="print_reciept" value="Print Reciept"/>
        </div>
    </div>
<?php endif; ?>