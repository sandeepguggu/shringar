<div class="content-menu-body invoice">
    <form id="invoice" class="form-horizontal" action="#" method="post">
        <div class="content-header">
            <h3>Exchange</h3>
            <b class="pull-right">Date: <?php echo date('M jS,  Y'); ?></b>
        </div>
        <div class="content-subject">
            <div class="block">
                <label class="input-small pull-left">Bill ID:</label>
                <input type="text" id="suggest_invoice" class="input-medium" autocomplete="off" value = "<?php if(isset($bill_id)) {echo $bill_id; }?>"/>
            </div>
            <div id="suggest_invoice_table">
            <?php if(isset($status)) { echo $msg; }?>
            </div>
        </div>
        <!--<div class="content-footer">
            <button type="button" class="btn btn-danger pull-right input-small" onclick="invoice.resetForm()">
                Reset
            </button>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary pull-right input-small" onclick="invoice.submit(this)"
                    url="<?php /*echo site_url('invoice/generate_bill/1/0/0'); */?>" btnname="invoice">
                Exchange
            </button>
        </div>-->
    </form>
</div>
<script type="text/javascript">
    element.key_up('#suggest_invoice', exchange.suggest);
</script>