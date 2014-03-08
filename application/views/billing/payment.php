<style>
.box {
	width:100%;
        overflow: hidden;
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
</style>
<script type="text/javascript">
    function processAmount() {
        var cash = $("#pay_by_cash").val() != '' ? parseFloat($("#pay_by_cash").val()):0;
        var note = 0;
        for(i=1; i<=5; i++) {
            note += $("#pay_by_credit_value"+i).val() != '' ? parseFloat($("#pay_by_credit_value"+i).val()):0;
        }
        var card = $("#pay_by_card").val() != '' ? parseFloat($("#pay_by_card").val()):0;
        var total = parseFloat($("#pay_amount").val());
        //if(total < cash+note+card && cash > 0) {
            $("#return-amount").html(((cash+note+card) - total).toFixed(2));
        //} else {
           // $("#return-amount").html('0');
        //}
    }
    function creditNote(id) {
        var note_id = $("#pay_by_credit"+id).val() != '' ? parseFloat($("#pay_by_credit"+id).val()):0;
        for(i=1; i<=5; i++) {
            if(note_id == $("#pay_by_credit"+i).val()) {
                if(id != i) {
                    $("#pay_by_credit_value"+id).val('');
                    return;
                }
            }
        }
        if(note_id != 0) {
            
            $.ajax({ 
                type: 'POST', 
                url: '/index.php/billing/credit_note_ajax', 
                data: {
                        id: note_id,
                        json: 1
                      },
                datatype: 'json', 
                success: function(data){
                    data = jQuery.parseJSON(data); 
                    if(! jQuery.isEmptyObject(data)) {
                        
                        if(data.used == 0 && data.customer_id == $("#customer_id").val()) {
                            $("#pay_by_credit_value"+id).val(data.amount);
                        } else {
                            $("#pay_by_credit_value"+id).val('');
                            
                        }
                    } else {
                        $("#pay_by_credit_value"+id).val('');
                    }
                    processAmount();
                }, 
                error: function(XMLHttpRequest, textStatus, errorThrown){ 
                    
                } 
            });
        }
    }
    function addcreditnote(value) {
        $('#credit_note_row_'+value).show();
    }
    $(function() {
        $('#form_invoice').validate({
            submitHandler: function(form) {
                var cash = $("#pay_by_cash").val() != '' ? parseFloat($("#pay_by_cash").val()):0;
                var note = 0;
                for(i=1; i<=5; i++) {
                    note += $("#pay_by_credit_value"+i).val() != '' ? parseFloat($("#pay_by_credit_value"+i).val()):0;
                }
                var card = $("#pay_by_card").val() != '' ? parseFloat($("#pay_by_card").val()):0;
                var total = parseFloat($("#pay_amount").val());
                
                if(total <= note && cash+card > 0) {
                    alert('Credit Notes are enough to process the Purchase');
                    return false;
                }
                
                else if(card != total && cash == 0 && note == 0) {
                    alert('We need exact amount for the Purchase');
                    return false;
                }

                else if( total <= cash+note+card) {
                    form.submit();
                } else {
                    alert('Please Pay the Money');
                }
            }
        });
    });
</script>
<form action="<?php echo site_url('billing/confirmed_and_print');?>" method="post" id="form_invoice">
    <?php
    foreach($_REQUEST as $k => $v){
            if(is_array($v)){
                    foreach($v as $v1){
                            echo '<input type="hidden" name="'.$k.'[]" value="'.$v1.'" />'."\n";
                    }
            }else{
                    echo '<input type="hidden" name="'.$k.'" value="'.$v.'" />'."\n";
            }
    }
    ?>
    
<div class="box">
    <div class="left b">Invoice</div>
    <div class="right"><span class="b">Date &amp; Time</span>:<?php echo date('l jS \of F Y h:i:s A'); ?></div>
</div>
    
<br /> 

<div class="box mt_20"> 
    <span style="width:100%; display:block; float:left; padding-bottom:20px;">
        Customer Type : <b><?php echo $customer_type; ?> </b>
    </span>
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

<br />

<fieldset>
    <legend>Payment</legend>
    <table style="margin:0px; padding:0px;" class="no-border large-table" >
        <tbody>
            <tr>
                <td width="25%">
                    <label for="pay_by_card">Credit / Debit Card</label>
                </td>
                <td width="25%">
                    <input type="text" class="number" autocomplete="off" id="pay_by_card" name="pay_by_card" onkeyup="processAmount()" />
                </td>
            </tr>
            <tr>
                <td width="25%">
                    <label for="pay_by_cash">Cash</label>
                </td>
                <td width="25%">
                    <input type="text" class="number" autocomplete="off" id="pay_by_cash" name="pay_by_cash" onkeyup="processAmount()" />
                </td>
            </tr>
            <tr id="credit_note_row_1">
                <td width="25%">
                    <label for="pay_by_credit1">Credit Note ID 1</label>
                </td>
                <td width="25%">
                    <input type="text" class="number" autocomplete="off" id="pay_by_credit1" name="pay_by_credit1" onkeyup="creditNote('1')" <?php if($credit_note_id != -1) { echo 'value="'.$credit_note_id.'"';} ?> />
                    <i class="icon-plus"></i>
                </td>
                <td width="25%">
                    <input type="text" autocomplete="off" id="pay_by_credit_value1" disabled="disabled" <?php if($credit_note_id != -1) { echo 'value="'.$credit_note_amount.'"';} ?> />
                </td>
                <td><input type="button" class="btn primary" onclick="addcreditnote(2)" value="Add"></td>
            </tr>
            <tr id="credit_note_row_2" style="display: none">
                <td width="25%">
                    <label for="pay_by_credit2">Credit Note ID 2</label>
                </td>
                <td width="25%">
                    <input type="text" class="number" autocomplete="off" id="pay_by_credit2" name="pay_by_credit2" onkeyup="creditNote('2')" />
                </td>
                <td width="25%">
                    <input type="text" autocomplete="off" id="pay_by_credit_value2" onkeyup="" disabled="disabled" />
                </td>
                <td><input type="button" class="btn primary" onclick="addcreditnote(3)" value="Add"></td>
            </tr>
            <tr id="credit_note_row_3" style="display: none">
                <td width="25%">
                    <label for="pay_by_credit3">Credit Note ID 3</label>
                </td>
                <td width="25%">
                    <input type="text" class="number" autocomplete="off" id="pay_by_credit3" name="pay_by_credit3" onkeyup="creditNote('3')" />
                </td>
                <td width="25%">
                    <input type="text" autocomplete="off" id="pay_by_credit_value3" onkeyup="" disabled="disabled" />
                </td>
                <td><input type="button" class="btn primary" onclick="addcreditnote(4)" value="Add"></td>
            </tr>
            <<tr id="credit_note_row_4" style="display: none">
                <td width="25%">
                    <label for="pay_by_credit4">Credit Note ID 4</label>
                </td>
                <td width="25%">
                    <input type="text" class="number" autocomplete="off" id="pay_by_credit4" name="pay_by_credit4" onkeyup="creditNote('4')" />
                </td>
                <td width="25%">
                    <input type="text" autocomplete="off" id="pay_by_credit_value4" onkeyup="" disabled="disabled" />
                </td>
                <td><input type="button" class="btn primary" onclick="addcreditnote(5)" value="Add"></td>
            </tr>
            <tr id="credit_note_row_5" style="display: none">
                <td width="25%">
                    <label for="pay_by_credit5">Credit Note ID 5</label>
                </td>
                <td width="25%">
                    <input type="text" class="number" autocomplete="off" id="pay_by_credit5" name="pay_by_credit5" onkeyup="creditNote('5')" />
                </td>
                <td width="25%">
                    <input type="text" autocomplete="off" id="pay_by_credit_value5" onkeyup="" disabled="disabled" />
                </td>
            </tr>
        </tbody>
    </table>
</fieldset>

<br />

<table class="table zebra-striped">
    <tbody>
        <tr>
            <td>Collect : <b>Rs. <?php echo $pay_amount; ?> /-</b></td>
            <td>Return : <b>Rs. <span id="return-amount">0</span> /-</b></td>
            <input type="hidden" id="pay_amount" value="<?php echo $pay_amount; ?>"/>
            <input type="hidden" id="customer_id" value="<?php echo $customer_id; ?>"/>
        </tr>
    </tbody>
</table>

<br />

<div class="box mt_20">
    <div class="items">
        <table width="100%" class="zebra-striped" id="product_table">
            <tr>
                <th>Sl No</th>
                <th>Items</th>
                <th>Qnt</th>
                <th>Price</th>
                <th>Vat(%)</th>
                <th>Total</th>
            </tr>
            <?php echo $products; ?>
            <tr id="product_table_total">
            <td colspan="5">Total Amount</td>
            <td id="product_table_total_amount"><?php echo $product_total_amount; ?></td>
            </tr>

            <tr>
            <td colspan="5">Discount Type : <?php echo $discount_option; ?><br />
                                            Discount Value : <?php echo $discount_value; ?><br />
                            </td>
            <td id="product_table_final_amount"><?php echo $pay_amount;?></td>
            </tr>
        </table>
        <input id="payment-submit" type="submit" value="Confirm" class="btn primary large" /> &nbsp;
        <a href="<?php echo site_url('billing/invoice'); ?>" class="btn danger large" onclick="if(!confirm('Are you sure?')) return false;">Cancel</a> 
        </div>
</div>
</form>