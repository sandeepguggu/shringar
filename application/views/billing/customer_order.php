<script type="text/javascript" src="<?php echo base_url('resources/js/billing/customer_order.js'); ?>"></script>
<?php if (isset($access)): ?>
    <div class="access-denied">
        <?php echo $access; ?>
    </div>
<?php endif; ?>

<div class="customer-order">
    <form id="co-form" action="<?php echo site_url('billing/order'); ?>" method="post">
        <h3 class="pull-left">Customer Order</h3>
        <b class="pull-right my-font">Date: <?php echo date('M jS,  Y'); ?></b>
        <br />
        <hr />
        <fieldset>
            <label class="pull-left span4">Customer Name or Mobile:</label>
            <div class="autocomplete-jui pull-left">
                <div class="ui-widget">
                    <input type="text" class="customer-name" autocomplete="off" />
                </div>
            </div>
            <a href="<?php echo site_url('customer/add'); ?>" class="btn primary Large fancybox pull-right">Add New Customer</a>
            <input type="hidden" name="customer-id" value="" />
        </fieldset>
        <div class="customer-details my-block"></div>
        <br />
        <h4>Add Product</h4>
        <fieldset style="background-color:#e5e5e5;">
            <div class="my-block">
                <label class="span4 pull-left">Product Name</label>
                <div class="autocomplete-jui span3 pull-left">
                    <div class="ui-widget">
                        <input autocomplete="off" id="product_name"/>
                    </div>
                </div>
                <a id="add-product-button" 
                   href="<?php echo site_url('product/add?ajax=1&pt=3'); ?>"
                   class="btn primary Large fancybox pull-right">Add Ornament</a>
                <input type="hidden" name="add-product-url-hidden" value="<?= site_url('product/add?ajax=1'); ?>"/>
            </div>
        </fieldset>

        <div id="co-Ornament-table" class="hide">
            <input type="hidden" name="co-Ornament-table-rows" id="co-Ornament-table-rows" value="0">
            <input type="hidden" id="row-count" value="1">
            <b>Ornament</b>
            <br/>
            <table style="width: 99%" class="my-table" id="selected_Ornaments">
                <tr>
                    <th class="my-span1 meta-head">ID</th>
                    <th class="meta-head" colspan="2">Name</th>
                    <th class="my-span1 meta-head">Weight</th>
                    <th class="my-span1 meta-head">Quantity</th>
                    <th class="my-span1 meta-head">Rate</th>
                    <th class="my-span1 meta-head">Price</th>
                    <th class="my-span4 meta-head">Total</th>
                    <th class="my-span1 meta-head">&nbsp;</th>
                </tr>
                <tr id="product_Ornament_footer">
                    <td colspan="3" class="my-border-left-no my-border-bottom-no my-border-right">&nbsp;</td>
                    <td colspan="4" class="my-border-bottom my-border-right"><b class="pull-right">Sub Total</b></td>
                    <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="ornament-sub-total pull-right"></b></td>
                </tr>
                <tr>
                    <td colspan="3" class="my-border-left-no my-border-bottom-no my-border-right">&nbsp;</td>
                    <td colspan="4" class="my-border-bottom my-border-right"><b class="pull-right">Vat</b></td>
                    <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="ornament-vat pull-right"></b></td>
                </tr>
                <tr>
                    <td colspan="3" class="my-border-left-no my-border-bottom-no my-border-right">&nbsp;</td>
                    <td colspan="4" class="my-border-bottom my-border-right"><b class="pull-right">Total</b></td>
                    <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="ornament-final-total pull-right"></b></td>
                </tr>
            </table>
            <fieldset class="my-block">
                <div class="my-block">
                    <label class="pull-left span4">Advance</label>
                    <input type="text" class="span4 number pull-left" name="customer_advance"/>
                </div>
                <br />
                <div class="my-block">
                    <label class="pull-left span4">Gold Rate:</label>
                    <input type="radio" name="rate-type" value="now" class="pull-left my-radio"/>
                    <label class="pull-left span2 my-radio-text">Today</label>
                    <input type="radio" name="rate-type" value="delivery" class="pull-left my-radio" checked/>
                    <label class="pull-left span2 my-radio-text">Delivery Date</label>
                </div>
            </fieldset>
            <div class="my-block">
                <input type="submit" value="Submit" class="btn primary" />
                <a href="<?php echo site_url('billing/customer_order'); ?>" class="btn danger">Reset</a>
            </div>
        </div>
    </form>
</div>