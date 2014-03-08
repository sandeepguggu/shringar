<?php
$print_state = isset($print) ? $print : 0;

$id = isset($output['id']) ? $output['id'] : '';
$name = isset($output['name']) ? $output['name'] : '';
$brand = isset($output['brand']) ? $output['brand'] : '';
$tax_category = isset($output['tax_category']) ? $output['tax_category'] : '';
$class = isset($output['class']) ? $output['class'] : '';
$description = isset($output['description']) ? $output['description'] : '';
$barcode = isset($output['header_mfg_barcode']) ? $output['header_mfg_barcode'] : '';
$img = isset($output['header_img']) ? $output['header_img'] : base_url('resources/img/product_default.gif');
?>
<script language="javascript">
    $(document).ready(function () {
        $('#product_header_view_barcode').barcode("<?php echo $barcode; ?>", "code128", {barWidth:1, barHeight:40});
    <?php
    if ($print_state == 1) {
        echo 'window.print();';
    }
    ?>
    });
</script>


<div class="content-header">
    <h3><?php echo $name; ?></h3>
</div>
<div class="content-subject">
    <div class="pull-left">
        <div class="polaroid">
            <img alt="Product Image" src="<?php echo $img;?>" width="125" height="125"/>
        </div>
        <div id="product_header_view_barcode" class="barcode"></div>
    </div>
    <div class="pull-left span5">
        <table class="table table-bordered table-description">
            <tr>
                <td>Name:</td>
                <td><?php echo $name;?></td>
            </tr>
            <tr>
                <td>Brand:</td>
                <td><?php echo $brand;?></td>
            </tr>
            <tr>
                <td>Tax Category:</td>
                <td><?php echo $tax_category;?></td>
            </tr>
            <tr>
                <td>Classification:</td>
                <td><?php echo $class;?></td>
            </tr>
            <tr>
                <td>Description:</td>
                <td><?php echo $description;?></td>
            </tr>
            <?php
            if(!isset($output['attributes']) || !is_array($output['attributes']) || count($output['attributes']) < 1){
                log_message('error', '#62, product_header.php error');
                $output['attributes'] = array();
            }
            log_message('error', print_r($output['attributes'], 1));
            foreach($output['attributes'] as $attribute) {
                $attribute_name = ucfirst($attribute['name']);
                $attribute_value = $attribute['value'];
               // $attribute_value = ($attribute['sku'] == 0) ? $attribute['value'] : '';
                echo '<tr>';
                echo '<td>'.$attribute_name.':</td>';
                echo '<td>'.$attribute_value.'</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</div>
<?php if($print_state == 0): ?>
<div class="content-footer">
    <a class="btn btn-success pull-right" target="_blank" href="<?php echo site_url('product/view_product_header/1?id='.$id);?>">
        <i class=" icon-print icon-white"></i>
        Print
    </a>
    <span class="pull-right">&nbsp;&nbsp;</span>
    <button type="button" class="btn btn-primary pull-right" onclick="$.fancybox.close()">
        <i class="icon-ok-circle icon-white"></i>
        &nbsp;Ok
    </button>
</div>
<?php endif; ?>