<!--<div class="create_btn">
    <a class="btn content-menu selected" href="#">CREATE GRN</a>
    <a class="btn content-menu" href="<?php /*echo site_url('grn/saved'); */?>">SAVED GRN</a>
</div>-->
<div class="content-menu-body opening-stock">
    <form id="opening_stock_form" class="form-horizontal"
          action="<?php echo site_url('inventory/submit_opening_stock'); ?>" method="post" onsubmit="return">
        <div class="content-header">
            <h3>Opening Stock</h3>
            <b class="pull-right">Date: <?php echo date('M jS,  Y'); ?></b>
        </div>
        <div class="content-subject">
            <div class="block hide-this">
                <label class="input-small pull-left">Product:</label>

                <div class="autocomplete-jui">
                    <div class="ui-widget">
                        <input id="product_ac" type="text" class="input-medium" autocomplete="off"/>
                    </div>
                </div>
            </div>

            <hr class="hide-this" style="margin: 10px 0">

            <input type="hidden" id="grn-row-count" value="0"/>

            <h3>Products</h3>
            <table class="table table-bordered" id="grn-table">
                <tr>
                    <th style="20px">S.No.</th>
                    <th>Product Name</th>
                    <th>Attributes</th>
                    <th>Price [Qnty]</th>
                    <th>Qty</th>
                    <!--<th>Price</th>
                    <th>Total</th>-->
                    <th style="20px">&nbsp;</th>
                </tr>
            </table>
        </div>
        <div class="content-footer">
            <a href="<?php echo site_url('inventory/opening_stock'); ?>" class="btn btn-danger pull-right hide-this">Cancel</a>
            <span class="pull-right hide-this">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary pull-right hide-this" onclick="$(this).submit()">
                <i class="icon-ok-circle icon-white"></i>
                &nbsp;Submit
            </button>
            <a href="<?php echo site_url('inventory/opening_stock'); ?>"
               class="btn btn-primary pull-right hide-this hide">Create</a>
        </div>
    </form>
</div>
<div id="print-area" class="hide"></div>
<script type="text/javascript">
    app.autocomplete('#product_ac', '<?php echo site_url('product/suggest_product?json=1&from=o_stock&stock=1');?>', opening_stock.add, config.opening_stock);
    element.key_up('#product_ac', opening_stock.productBarcode, config.opening_stock);

    element.focus('.opening-stock input', validation.focus);
    element.key_up('.opening-stock input', validation.focus);
    validation.bind({
        formId:config.opening_stock.form_id,
        callback:opening_stock.submit,
        successCallback:opening_stock.success,
        ajaxSubmit:true
    });
</script>