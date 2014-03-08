<script type="text/javascript" src="<?php echo base_url('resources/js/jquery-1.7.2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resources/js/jquery-barcode-2.0.2.js'); ?>"></script>
<script language="javascript">
    $(document).ready(function () {
        $('.print-product').find('.barcode-target').barcode("<?php echo $barcode; ?>", "code128", {barWidth:1, barHeight:15, fontSize:9});
        var html = '<div class="barcode-name">Bangle</div>';
        html += '<div class="barcode-price">Rs. 100&nbsp;&nbsp;</div>';
        //$('.print-product').find('.barcode-target div:last-child').attr('style', '');
        //$('.print-product').find('.barcode-target div:last-child').addClass('barcode-footer');
        //$('.print-product').find('.barcode-target').append(html);
        window.print();
    });
</script>
<style type="text/css" media="all">
    .print-product {
        padding-top: 5px;
    }

    .barcode-footer {
        font-size: 8px;
        line-height: 11px;
        text-align: center;
        clear: both;
    }

    .barcode-name {
        float: left;
        font-size: 8px;
        line-height: 11px;
        width: 50%;
        height: 11px;
        overflow: hidden;
    }

    .barcode-price {
        text-align: right;
        float: left;
        font-size: 8px;
        line-height: 11px;
        width: 45%
    }

    .product-description span {
        font-size: 8px;
    }
</style>
<div class="print-product">
    <div class="barcode-target"></div>
    <div class="barcode-description">
        <div class="barcode-name">Bangle</div>
        <div class="barcode-price">MRP : Rs. 100/-</div>
    </div>
</div>
