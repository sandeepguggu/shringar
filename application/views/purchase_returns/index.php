<div class="" align="center">
    <a class="btn content-menu selected" href="#">RETURN</a>
    <a class="btn content-menu" href="<?php echo site_url('purchase_returns/saved'); ?>">REPORTS</a>
</div>
<div class="content-menu-body purchase-returns">
    <form id="purchase_returns_form" class="form-horizontal"
          action="<?php echo site_url('purchase_returns/confirm_purchase_return'); ?>" method="post">
        <div class="content-header">
            <h3>Purchase Returns</h3>
            <b class="pull-right">Date: <?php echo date('M jS,  Y'); ?></b>
        </div>
        <div class="content-subject">
            <div class="block">
                <label class="input-medium pull-left">GRN #:</label>
                <input type="text" id="grn_id" class="input-small pull-left" autocomplete="off"/>
                <input type="hidden" name="grn_id" id="grn_id_hidden"/>
                &nbsp;
                <button type="button" id="load_from_grn" class="btn btn-primary">
                    <i class="icon-download icon-white"></i>
                </button>
                <span class="pull-right">&nbsp;</span>

                <div class="autocomplete-jui pull-right">
                    <div class="ui-widget">
                        <input id="product_ac" type="text" class="input-medium"/>
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

            <div class="block" id="vendor_block">
            </div>

            <input type="hidden" name="vendor_id" id="vendor_id"/>

            <div class="grn-vendor-block hide block">
                <div class="pull-left address-block">
                </div>
                <div class="pull-right address-block">
                    <strong class="span2">PO Date:</strong>2012-05-16<br>
                    <strong class="span2">Payment Date:</strong>2012-05-16<br>
                </div>
            </div>

            <input type="hidden" id="purchase-returns-row-count" value="0"/>

            <h3>Products</h3>
            <table class="table table-bordered" id="purchase-returns-table">
                <tr>
                    <th style="20px">S.No.</th>
                    <th width="25%">Product Name</th>
                    <th>Brand</th>
                    <th width="75%">Attributes</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th style="20px">&nbsp;</th>
                </tr>
                <tr class="table-footer">
                    <th colspan="4"></th>
                    <th colspan="2" class="text-right">Total</th>
                    <th class="text-right" id="purchase_returns_sub_total">0.00</th>
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
    element.click('#load_from_grn', purchaseReturns.loadFromGRN, config.purchaseReturns);

    app.autocomplete('#product_ac', '<?php echo site_url('product/suggest_product?ajax=1&details=1'); ?>', purchaseReturns.productAutocomplete, config.purchaseReturns);
    element.key_up('#product_ac', purchaseReturns.productBarcode, config.purchaseReturns);
    app.autocomplete('#vendor_ac', '<?php echo site_url('vendor/suggest_vendors?json=1&from=po'); ?>', purchaseReturns.selectVendor, config.purchaseReturns);

    element.focus('.grn input', validation.focus);
    element.key_up('.grn input', validation.focus);
    validation.bind({
        formId:config.purchaseReturns.form_id,
        callback:purchaseReturns.submit
    });
</script>