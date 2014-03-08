<?php
if (!isset($ajax)) {
    $ajax = false;
}
$cur_tab = 1;
if (!isset($tab)) {
    $tab = 'default';
}
$tabs = array();
$tabs[] = array("index" => 1,
    "title" => '<span class="span_img inventory_stock"></span>STOCK',
    "name" => "stock",
    "href" => site_url('inventory/stock?tabs=1'),
    "class" => "",
    'url' => 'inventory/stock'
);
$tabs[] = array("index" => 2,
    "title" => '<span class="span_img inventory_reports"></span>REPORTS',
    "name" => "report",
    "href" => site_url('inventory/reports?tabs=1'),
    "class" => "",
    'url' => 'inventory/reports'
);
$tabs[] = array("index" => 3,
    "title" => '<span class="span_img inventory_stock"></span>OPENING STOCK',
    "name" => "opening_stock",
    "href" => site_url('inventory/opening_stock?tabs=1'),
    "class" => "",
    'url' => 'inventory/opening_stock'
);
if ($ajax === false) {
    ?>
<div id="tabs" class="ui-tabs">
    <ul class="ui-tabs-nav">
        <li style="display:none; width:0px; height:0px;"><a href="#tabs-1">Preloaded</a></li>
        <?php
        foreach ($tabs as $t) {
            echo '<li class="' . (($t['name'] == $tab) ? 'ui-tabs-selected ' : '') . $t['class'] . '" url="' . $t['url'] . '">';
            if ($t['name'] == $tab) {
                echo '<a href="#ui-tabs-' . $t['index'] . '">' . $t['title'] . '</a>';
            } else {
                echo '<a href="' . $t['href'] . '">' . $t['title'] . '</a>';
            }
            echo '</li>';
            $cur_tab++;
        }
        ?>
    </ul>
    <div id="tabs-1">
        <h2>INVENTORY SECTION</h2>

        <div style="margin-left:20px;">
            <ul>
                <li>You can add new stock to inventory or view current stock</li>
                <li>You can view reports</li>

            </ul>
        </div>
    </div>
    <?php
    foreach ($tabs as $t) {
        if ($tab == $t['name']) {
            echo '<div id="ui-tabs-' . $t['index'] . '">';
            echo $output;
            echo '</div>';
        }
    }
    ?>
</div>
<script>
    tabs.bind({
        tabsId:'#tabs'
    });
</script>
<?php
} else {
    echo $output;
}
?>