<?php if (isset($access)): ?>
    <div class="access-denied">
        <?php echo $access; ?>
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url('resources/js/billing/old_purchase.js'); ?>"></script>
<div class="old-purchase">
    <form id="old_purchase" action="<?php echo site_url('billing/confirm_purchase_bill'); ?>" method="post">
        <h3 class="pull-left">Old Metal Purchase</h3>
        <b class="pull-right my-font">Date: <?php echo date('M jS,  Y h:i A'); ?></b>
        <br />
        <hr />

        <!-- @Customer Auto complete -->
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
        <!-- @Customer Auto complete -->

        <!-- @Product Auto Complete -->
        <h4>Add Product</h4>
        <fieldset style="background-color:#e5e5e5;">
            <label class="span3 pull-left">Product Type</label>
            <select name="product-type" class="pull-left">
                <?php
                foreach ($output['entities'] as $entity) {
                    if ($entity['id'] == 1) {
                        echo '<option value="' . $entity['id'] . '" selected>' . $entity['display_name'] . '</option>';
                    } else {
                        //echo '<option value="' . $entity['id'] . '">' . $entity['display_name'] . '</option>';
                    }
                }
                ?>
            </select>
            <label class="pull-left span1">&nbsp;</label>
            <label class="span3 pull-left">Product Name</label>
            <div class="autocomplete-jui span3 pull-left">
                <div class="ui-widget">
                    <input autocomplete="off" class="product_name"/>
                </div>
            </div>
            <a id="add-product-button" href="<?php echo site_url('product/add?ajax=1&pt=3'); ?>"
               class="btn primary Large fancybox pull-right">Add Ornament</a>
            <input type="hidden" name="add-product-url-hidden" value="<?= site_url('product/add?ajax=1'); ?>"/>
        </fieldset>
        <!-- @Product Auto Complete -->

        <!-- @Product Tables -->
        <div id="op-Metal-table" class="hide">
            <input type="hidden" name="op-Metal-table-rows" id="op-Metal-table-rows" value="0">
            <h4>Metal</h4>
            <table style="width:99%" class="my-table" id="selected_Metals">
                <tr>
                    <th class="my-span1 meta-head my-border-left">ID</th>
                    <th class="meta-head">Metal Name</th>
                    <th class="my-span1 meta-head">Fineness</th>
                    <th class="my-span3 meta-head">Gr. Wt.</th>
                    <th class="my-span3 meta-head">Nt. Wt.</th>
                    <th class="my-span3 meta-head">Rate</th>
                    <th class="meta-head my-span5">Price</th>
                    <th class="span2 meta-head my-border-right">&nbsp;</th>
                </tr>
                <tr id="product_Metal_footer">
                    <td colspan="4" class="my-border-right my-border-bottom-no my-border-left-no">&nbsp;</td>
                    <td colspan="2" class="my-border-right my-border-bottom"><b class="pull-right">Total</b></td>
                    <td colspan="2" class="my-border-bottom my-border-right">
                        <b class="pull-left">Rs.</b><b class="metal-final-total pull-right">0.00</b>
                        <input type="hidden" name="total_amount" val="0" />
                    </td>
                </tr>
            </table>
            <div class="my-block">
                
                <input type="radio" name="paid_amount" value="amount"/>
                <span class="span2">&nbsp;</span>
                <span class="span2 my-font">Pay by Cash</span>
                <span class="span2">&nbsp;</span>
                <input type="text" name="cash_paid" class="span2 pull-left" style="display: none"/>
                <br />
                <br />
                <span class="span2">&nbsp;</span>
                <input type="radio" name="paid_amount" class="pull-left" value="later" checked/>
                <span class="span2">&nbsp;</span>
                <span class="span2 my-font">Use for New Ornament</span>
            </div>
            <br />
            <input type="submit" value="OK" class="btn primary" />
            <a class="btn danger" href="<?php echo site_url('billing/purchase_bill'); ?>">Reset</a>
        </div>
        <!-- @Product Tables -->        
    </form>
</div>