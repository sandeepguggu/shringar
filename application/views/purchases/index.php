<?php
if (!isset($ajax)) {
    $ajax = false;
}
$cur_tab = 1;
if (!isset($tab)) {
    $tab = 'default';
}
$tabs = array();
$tabs[] = array("index" => 1, "title" => '<span class="span_img per_order"></span>' . "PURCHASE ORDER", "name" => "po", "href" => site_url('po?tabs=1'), "class" => "first", 'url' => 'po');
$tabs[] = array("index" => 2, "title" => '<span class="span_img grn"></span>' . "Goods Received Note", "name" => "grn", "href" => site_url('grn?tabs=1'), "class" => "", 'url' => 'grn');
$tabs[] = array("index" => 3, "title" => '<span class="span_img mng_ven"></span>' . "Manage Vendors", "name" => "vendor", "href" => site_url('vendor?tabs=1'), "class" => "", 'url' => 'vendor');
$tabs[] = array("index" => 4, "title" => '<span class="span_img brand"></span>' . "Manage Brands", "name" => "brand", "href" => site_url('brand?tabs=1'), "class" => "", 'url' => 'brand');
$tabs[] = array("index" => 5, "title" => '<span class="span_img mng_cat"></span>' . "Manage Category", "name" => "category", "href" => site_url('category?tabs=1'), "class" => "", 'url' => 'category');
$tabs[] = array("index" => 6, "title" => '<span class="span_img mng_cat"></span>' . "Manage Classification", "name" => "class", "href" => site_url('classification?tabs=1'), "class" => "", 'url' => 'classification');
$tabs[] = array("index" => 7, "title" => '<span class="span_img mng_prd"></span>' . "Manage Products", "name" => "product", "href" => site_url('product?tabs=1'), "class" => "", 'url' => 'product');
//$tabs[] = array("index" => 7, "title" => '<span class="span_img mng_prd"></span>' . "Manage Products", "name" => "product", "href" => site_url('product?tabs=1'), "class" => "", 'url' => 'product');

if ($ajax === false) {
    ?>
<div id="tabs" class="ui-tabs">
    <ul class="ui-tabs-nav">
        <li style="display:none; width:0px; height:0px;"><a href="#tabs-1">Preloaded</a></li>
        <?php
        foreach ($tabs as $t) {
            echo '<li class="' . (($t['name'] == $tab) ? 'ui-tabs-selected ' : '') . $t['class'] . '" url="'.$t['url'].'">';
            if ($t['name'] == $tab) {
                echo '<a href="#ui-tabs-' . $t['index'] . '">' . $t['title'] . '</a>';
                $selected = $cur_tab;
            } else {
                echo '<a href="' . $t['href'] . '">' . $t['title'] . '</a>';
            }
            echo '</li>';
        }
        ?>
    </ul>
    <div id="tabs-1">
        <h2>Purchases & Inventory Section</h2>

        <div style="margin-left:20px;">
            <ul>
                <li>Create New PO</li>
                <li>GRN</li>
            </ul>
        </div>
    </div>
    <?php
    foreach ($tabs as $t) {
        if ($tab == $t['name']) {
            echo '<div class="ui-tabs-panel"     id="ui-tabs-' . $t['index'] . '">';
            echo $output;
            echo '</div>';
        }
    }
    ?>
</div>
<script>
    $(function () {
        tabs.bind({
            tabsId : '#tabs'
        });
    });
</script>
<?php
}
else {
    echo $output;
}
?>
