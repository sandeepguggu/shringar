<div class="" align="center">
    <a class="btn content-menu selected" href="#">CREATE PO</a>
    <a class="btn content-menu" href="<?php echo site_url('po/saved'); ?>">SAVED PO</a>
</div>
<div class="content-menu-body purchase-order">
    <form id="po" class="form-horizontal" name="po" action="<?php echo site_url('/po/review'); ?>" method="post">
        <div class="content-header">
            <h3>Purchase Order</h3>
            <b class="pull-right">Date: <?php echo date('M jS,  Y'); ?></b>
        </div>
        <div class="content-subject">
            <div class="row-fluid">
                <div class="span8 form-box row-fluid">
                    <div class="row-fluid">&nbsp;</div>
                    <div class="row-fluid">
                        <div class="span6 row-fluid">
                            <label class="span6">PO Date:</label>
                            <input id="po_date" class="required span6" type="text" name="po_date" value="<?php echo date('m/d/Y'); ?>"
                                   autocomplete="off"/>
                        </div>
                        <div class="span6 row-fluid">
                            <label class="span6">D. Date:</label>
                            <input id="delivery_date" class="required span6" type="text" value="<?php echo date('m/d/Y'); ?>"
                                   name="delivery_date" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6 row-fluid">
                            <label class="span6">Vendor:</label>
                            <div class="autocomplete-jui row-fluid">
                                <div class="ui-widget row-fluid">
                                    <input id="po_vendor_ac" class="span6" autocomplete="off"/>
                                    <input type="hidden" id="po_vendor_id" name="vendor_id">
                                </div>
                            </div>
                        </div>
                        <div class="span6 row-fluid">
                            <label class="span6">Branch:</label>
                            <input readonly class="required span6" type="text" name="branch_id" autocomplete="off" value="<?php echo $branch; ?>"/>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6 row-fluid">
                            <label class="span6">Contact Person:</label>
                            <div class="autocomplete-jui row-fluid">
                                <div class="ui-widget row-fluid">
                                    <input type="text" name="vendor_contact_person_name" id="po_contact_ac"
                                           class="required span6" autocomplete="off"/>
                                    <input type="hidden" id="po_vendor_contact_id" name="vendor_person_id"/>
                                    <input type="hidden" id="po_vendor_contact_id_update" name="vendor_contact_person_update_db" value="1"/>
                                </div>
                            </div>
                        </div>
                        <div class="span6 row-fluid">
                            <label class="span6">Mobile:</label>
                            <input type="text" name="vendor_contact_person_phone" id="vendor_contact_person_phone"
                                   class="required number span6"/>
                        </div>
                    </div>
                    <div class="row-fluid">&nbsp;</div>
                </div>
                <div class="span4 form-box">
                    <div class="row-fluid">
                        <label class="radio span10">X Days After Goods Received</label>
                        <input type="radio" name="payment_terms" value="terms_after_gr" class="span2"
                               style="float: right;"/>
                    </div>
                    <div class="row-fluid">
                        <label class="radio span10">PO Dated + X Days</label>
                        <input type="radio" name="payment_terms" value="terms_po_x_days" class="span2"
                               style="float: right;"/>
                    </div>
                    <div class="row-fluid">
                        <label class="radio span10">On Date</label>
                        <input type="radio" name="payment_terms" value="terms_on_date" class="span2" checked="checked"
                               style="float: right;"/>
                    </div>
                    <div class="row-fluid" id="po_on_date">
                        <label class="radio span6">Date:</label>
                        <input type="text" name="pay_on_date" id="pay_on_date" class="required hasDatePicker span6"
                               autocomplete="off"/>
                    </div>
                    <div class="row-fluid hide" id="po_x_days">
                        <label class="radio span6">Days:</label>
                        <input type="text" name="pay_days" id="pay_days" class="number span6" autocomplete="off"/>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="form-box">
                    <label class="span2">Product:</label>
                    <div class="autocomplete-jui span2">
                        <div class="ui-widget">
                            <input id="po_product_ac" type="text" class="span12"/>
                        </div>
                    </div>
                    <a id="vendor_add_btn" href="<?php echo site_url('product/add?ajax=1&pt=25&reload=0'); ?>"
                       class="btn btn-primary fancybox pull-right">
                        <i class="icon-tags icon-white"></i>
                        Add Product
                    </a>
                </div>

            </div>
            <input type="hidden" id="purchase-order-row-count" value="0"/>
            <table class="table table-bordered" id="purchase-order-table">
                <tr>
                    <th>S.No.</th>
                    <th width="25%">Product Name</th>
                    <th>Brand</th>
                    <th width="75%">Attributes</th>
                    <th>Price [Qnty]</th>
                    <th>Qty</th>
                    <!--<th>Price</th>
                    <th>Total</th>-->
                    <th>&nbsp;</th>
                </tr>
                <!--
                Undo comments for price calculation
                <tr class="table-footer">
                    <th colspan="3"></th>
                    <th colspan="2" class="text-right">Total</th>
                    <th class="text-right" id="po_sub_total">0.00</th>
                    <th>&nbsp;</th>
                </tr>
                -->
            </table>
        </div>
        <div class="content-footer">
            <a href="" class="btn btn-danger pull-right">
                <i class="icon-remove-circle icon-white"></i>
                &nbsp;Cancel
            </a>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary pull-right" onclick="$(this).submit()">
                <i class="icon-ok-circle icon-white"></i>
                &nbsp;Submit
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $( "#po_date" ).datepicker({
    });
    $( "#delivery_date" ).datepicker({});
    $( "#pay_on_date" ).datepicker({});
    element.change('input[name=payment_terms]', purchaseOrder.terms, config.po);
    app.autocomplete('#po_vendor_ac', '<?php echo site_url('vendor/suggest_vendors?json=1&from=po'); ?>', purchaseOrder.selectVendor, config.po);
    app.autocomplete('#po_contact_ac', '<?php echo site_url('vendor/suggest_vendors?json=1&from=po'); ?>', purchaseOrder.selectContactPerson, config.po );
    app.autocomplete('#po_product_ac', '<?php echo site_url('product/suggest_product?json=1&from=po&stock=1'); ?>', purchaseOrder.add, config.po);
    element.focus('.purchase-order input', validation.focus);
    element.key_up('.purchase-order input', validation.focus);
    validation.bind({
        formId: config.po.form_id,
        callback: purchaseOrder.submit
    });
    $('#po_contact_ac').autocomplete({
        minLength:2,
        appendTo:$('#po_contact_ac').parents('.autocomplete-jui'),
        source:function (request, response) {
            var vendor_id = $(config.po.vendor_id).val();
            if(vendor_id == '') {
                response({});
            } else {
                var url = site_url + "/vendor/suggest_person?json=1&vendor_id=" + vendor_id;
                $.getJSON(url, request, function (data, status, xhr) {
                    response(data);
                });
            }
        },
        select:function (e, ui) {
            console.log(ui);
            var id = typeof(ui.item.row.id) != 'undefined' ? ui.item.row.id : '';
            var phone = typeof(ui.item.row.contact_phone) != 'undefined' ? ui.item.row.contact_phone : '';
            if( id != '') {
                $('#po_vendor_contact_id').val(id);
                $('#po_vendor_contact_id_update').val(0);
                $('#vendor_contact_person_phone').val(phone);
            }
        }
    });
</script>