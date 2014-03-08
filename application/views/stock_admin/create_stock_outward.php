<div class="" align="center">
    <a class="btn content-menu" href="<?php echo site_url('stock_admin/stock_outward'); ?>">SAVED</a>
    <a class="btn content-menu selected" href="#">CREATE</a>
</div>
<div class="content-menu-body purchase-returns">
    <form id="purchase_returns_form" class="form-horizontal"
          action="<?php echo site_url('purchase_returns/confirm_purchase_return'); ?>" method="post">
        <div class="content-header">
            <h3>Stock Outward</h3>
            <b class="pull-right">Date: <?php echo date('M jS,  Y'); ?></b>
        </div>
        <div class="content-subject">
            <div class="row-fluid">
                <div class="span4">
                    <label class="input-medium pull-left">Name / Code:</label>
                    <input type="text" class="input-medium pull-left required" name="">
                </div>
                <div class="span4">
                    <label class="input-medium pull-left">Date:</label>
                    <input type="text" class="input-medium pull-left required" name="date" id="so_date"
                           value="<?php echo date('m/d/Y h:m'); ?>">
                </div>
                <div class="span4">
                    <label class="input-medium pull-left">Return Date:</label>
                    <input type="text" class="input-medium pull-left" name="return_date" id="so_return_date">
                </div>
            </div>
            <br>

            <div class="row-fluid">
                <label class="span2 pull-left">Description</label>
                <textarea rows="1" class="input-xxlarge span10"></textarea>
            </div>
            <hr style="margin: 10px 0">


            <input type="hidden" id="purchase-returns-row-count" value="0"/>

            <div class="content-header">
                <h3>Products</h3>

                <div class="autocomplete-jui pull-right">
                    <div class="ui-widget">
                        <input id="product_ac" type="text" class="input-medium"/>
                    </div>
                </div>
            </div>
            <br>
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
            <button type="button" class="btn btn-danger pull-right" onclick="$.fancybox.close()">
                <i class="icon-remove-circle icon-white"></i>
                &nbsp;Cancel
            </button>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary pull-right" onclick="$(this).submit()">
                <i class="icon-ok-circle icon-white"></i>
                &nbsp;Submit
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $('#so_date').datetimepicker();
    $('#so_return_date').datetimepicker();

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