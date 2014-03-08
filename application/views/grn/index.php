<div class="" align="center">
    <a class="btn content-menu selected" href="#">CREATE GRN</a>
    <a class="btn content-menu" href="<?php echo site_url('grn/saved'); ?>">SAVED GRN</a>
</div>
<div class="content-menu-body grn">
    <form id="grn_form" class="form-horizontal" action="<?php echo site_url('/grn/review'); ?>" method="post">
        <div class="content-header">
            <h3>Goods Received Note</h3>
            <b class="pull-right">Date: <?php echo date('M jS,  Y'); ?></b>
        </div>
        <div class="content-subject">
            <div class="block">
                <label class="input-medium pull-left">PO #:</label>
                <input type="text" id="grn_po_id" class="input-small pull-left" autocomplete="off"/>
                <input type="hidden" name="po" id="grn_po_id_hidden"/>
                &nbsp;
                <button type="button" id="load_from_po" class="btn btn-primary">
                    <i class="icon-download icon-white"></i>
                </button>
                <a id="vendor_add_btn" href="<?php echo site_url('product/add?ajax=1&pt=25'); ?>"
                   class="btn btn-primary fancybox pull-right">
                    <i class="icon-tags icon-white"></i>
                </a>
                <span class="pull-right">&nbsp;</span>
                <div class="autocomplete-jui pull-right">
                    <div class="ui-widget">
                        <input id="grn_product_ac" type="text" class="input-medium" />
                    </div>
                </div>

                <label class="input-small pull-right">Product:</label>
            </div>

            <hr style="margin: 10px 0">

            <div class="block">
                <label class="input-medium pull-left">Vendor:</label>
                <div class="autocomplete-jui pull-left">
                    <div class="ui-widget">
                        <input id="vendor_ac" type="text" class="input-medium"/>
                    </div>
                </div>
            </div>

            <hr style="margin: 10px 0">

            <input type="hidden" name="vendor_id" id="grn_vendor_id" />
            <input type="hidden" name="po_date" id="grn_po_date">
            <input type="hidden" name="delivery_date" id="grn_delivery_date">
            <div class="grn-vendor-block hide block">
                <div class="pull-left address-block">
                </div>
                <div class="pull-right address-block">
                    <strong class="span2">PO Date:</strong>2012-05-16<br>
                    <strong class="span2">Payment Date:</strong>2012-05-16<br>
                </div>
            </div>

            <input type="hidden" id="grn-row-count" value="0"/>
            <h3>Products</h3>
            <table class="table table-bordered" id="grn-table">
                <tr>
                    <th style="20px">S.No.</th>
                    <th width="25%">Product Name</th>
                    <th>Brand</th>
                    <th width="75%">Attributes</th>
                    <th>Stock</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th style="20px">&nbsp;</th>
                </tr>
                <tr class="table-footer">
                    <th colspan="5"></th>
                    <th colspan="2" class="text-right">Total</th>
                    <th class="text-right" id="grn_sub_total">0.00</th>
                    <th style="20px">&nbsp;</th>
                </tr>
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
    element.click('#load_from_po', grn.loadFromPo, config.grn);
    app.autocomplete('#grn_product_ac', '<?php echo site_url('product/suggest_product?json=1&from=grn&stock=1');?>', grn.add, config.grn);
    element.key_up('#grn_product_ac', grn.productBarcode, config.grn);
    app.autocomplete('#vendor_ac', '<?php echo site_url('vendor/suggest_vendors?json=1&from=grn'); ?>', grn.selectVendor, config.grn);

    element.focus('.grn input', validation.focus);
    element.key_up('.grn input', validation.focus);
    validation.bind({
        formId: config.grn.form_id,
        callback: grn.submit
    });
</script>