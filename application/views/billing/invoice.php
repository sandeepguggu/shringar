<div class="create_btn" align="center">
    <a class="btn content-menu selected" href="#">&nbsp;CREATE</a>
    <!--<a class="btn content-menu" href="<?php /*echo site_url('invoice/saved'); */?>">&nbsp;SAVED&nbsp;&nbsp;</a>-->
    <a class="btn content-menu" href="<?php echo site_url('invoice/invoice_reports'); ?>">REPORTS</a>
</div>
<div class="content-menu-body invoice">
    <form id="invoice" class="form-horizontal"  method="post">
        <div class="content-header">
              <a href="<?php echo site_url('invoice/new_invoice')?>" target="_blank"><h3>New Invoice</h3></a>
            <b class="pull-right">Date: <?php echo date('M jS,  Y'); ?></b>
        </div>
        <div class="content-subject">
            <div class="block">
            <label class="input-small pull-left">Bill ID:</label>
                 <div id="bill_id" class="autocomplete-jui pull-left">
                    <div class="ui-widget">
                        <input type="text" id="bill_id" class="input-medium" autocomplete="off" value="<?php echo $bill_id + 1?>" disabled/>
                    </div>
                </div>
                 <span class="pull-left">&nbsp;&nbsp;</span>
                <label class="input-small pull-left">Customer:</label>

                <div id="customer_ac_div" class="autocomplete-jui pull-left">
                    <div class="ui-widget">
                        <input type="text" id="customer_ac" class="input-medium" autocomplete="off"/>
                        <span class="pull-left">&nbsp;&nbsp;</span>
                        <span class="add_customer">
                         <a class="btn btn-primary fancybox add_customer" href="<?php echo site_url('customer/add')?>">
                            <i class="icon-user icon-white"></i>
                        </a>
                        </span>
                    </div>
                </div>
                 <span class="pull-left">&nbsp;&nbsp;</span>
                
                <input type="hidden" id="invoice_customer_id" name="customer-id" value="<?php echo $customer_id?>"/>

                <address id="customer_details" class="pull-left hide">
                    <span class="pull-left">
                        <strong><?php echo $customer_name?></strong>
                        <br>
                        <abbr title="Mobile">P:</abbr>
                        9985024794
                    </span>
                    <i id="customer-remove-button" class="pull-right customer-remove-button"></i>
                </address>
                <div class="autocomplete-jui pull-right">
                    <div class="ui-widget">
                        <input type="text" id="product_ac" class="input-medium" autocomplete="off"/>
                    </div>
                </div>
                <label class="input-small pull-right">Product:</label>
            </div>

            <hr style="margin: 10px 0">
            <div class="content-header">
                <h3>Products</h3>
            </div>
            <input type="hidden" id="invoice-row-count" value="0"/>

            <div class="content-subject">
                <table class="table table-bordered" id="invoice-table">
                    <tr class="table-header">
                        <th>S.No.</th>
                        <th width="100%">Product Name</th>
                        <th>Brand</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Dis</th>
                        <th>Total</th>
                        <th>Add Tax</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr class="table-footer">
                        <th colspan="5" class="text-right">Sub Total</th>
                        <th class="text-right" id="invoice_sub_total">0.00</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right">VAT</th>
                        <th class="text-right" id="invoice_vat_amount">0.00</th>
                        <th style="20px">&nbsp;</th>
                    </tr>
                    <tr>
                        <th colspan = "2">&nbsp;</th>
                        <th>Total Quantity</th>
                        <td id = "total_quantity" style="text-align:right">0</td>
                        <th colspan="" class="text-right">Total</th>
                        <th class="text-right" id="invoice_total_amount">0.00</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </table>
                <input type="hidden" name="total_bill_amount" value="0"/>
            </div>

            <div class="content-header">
                <h3>Payment</h3>
                <input type="button" id="add_payment_btn" class="btn btn-primary pull-right" value="Add"/>
                <input type="text" id="payment_barcode" class="hide pull-right" placeholder="Barcode"/>
                <span class="pull-right">&nbsp;&nbsp;</span>
                <select id="payment_options" class="pull-right input-medium">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <!-- <option value="bill">Purchase Bill</option>-->
                    <option value="cheque">Cheque</option>
                    <!--<option value="advance">Customer Advance</option>-->
                    <!--<option value="scheme">Scheme Advantage</option>-->
                    <!--<option value="loyalty">Loyalty Points</option>-->
                </select>
            </div>
            <div class="content-subject">
                <table id="payment_block" class="table table-bordered">
                    <tr>
                        <td colspan="4">Cash</td>
                        <td class="span1">
                            <input type="text" name="invoice_cash_amt" autocomplete="off"
                                   class="input-mini required invoice-amount number text-right" min="0"
                                   placeholder="Amount" paytype="cash"/>
                        </td>
                        <td style="width: 20px">

                            <button type = "button" class="btn btn-danger action-button invoice-remove-btn" onclick="payment.removeRow(this)">                            

                                <i class="icon-trash icon-white"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="table-footer">
                        <th colspan="4" class="text-right">Total</th>
                        <th class="text-right" id="payment_total">0.00</th>
                        <th style="20px">&nbsp;</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="content-footer">
            <input type="hidden" id="invoice_button_type" value="invoice">
            <button type="button" class="btn btn-danger pull-right input-small shortcut" onclick="invoice.resetForm()">
                <u>R</u>eset
            </button>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary pull-right input-small shortcut" onclick="invoice.submit(this)"
                    url="<?php echo site_url('invoice/generate_bill/0/1/0'); ?>" btnname="estimate">
                <u>E</u>stimate
            </button>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary pull-right input-small shortcut" onclick="invoice.submit(this)"
                    url="<?php echo site_url('invoice/generate_bill/0/0/1'); ?>" btnname="cart">
                <u>C</u>art
            </button>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary pull-right input-small shortcut" onclick="invoice.submit(this)"
                    url="<?php echo site_url('invoice/generate_bill/1/0/0'); ?>" btnname="invoice">
                <u>I</u>nvoice
            </button>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary pull-right input-small shortcut" onclick="invoice.submit(this)"
                    btnname="print">
                <u>P</u>rint
            </button>
        </div>
    </form>
</div>

<div id="print-area" class="hide"></div>
<script type="text/javascript">

    fancyBox.bind();
    app.autocomplete('#customer_ac', '<?php echo site_url('customer/suggest?json=1'); ?>', invoice.selectCustomer, config.invoice);
    app.autocomplete('#product_ac', '<?php echo site_url('product/suggest_product?ajax=1&details=0'); ?>', invoice.productAutocomplete, config.invoice);
    element.key_up('#product_ac', invoice.productBarcode, config.invoice);    
    element.change('#payment_options', payment.changePaymentOptions, config.invoice);
    element.click('#add_payment_btn', payment.addPaymentOption, config.invoice);
    //element.keydown('.shortcut', invoice.shortCut);
    element.focus('.invoice input', validation.focus);
    element.key_up('.invoice input', validation.focus);
    element.key_up('#payment_block .invoice-amount', payment.total);


    
    validation.bind({
        formId:config.invoice.form_id,
        callback:invoice.validate
    });

    invoice.addShortCut();
    element.mouseOver('#customer_details', invoice.highlightRemoveButton);
    element.mouseOut('#customer_details', invoice.unhighlightRemoveButton);
    element.click('#customer-remove-button', invoice.resetForm);

    $("#customer_details").show();
    $("#customer_ac").hide();
    $(".add_customer").hide(); 
    $("#product_ac").focus();   

</script>


