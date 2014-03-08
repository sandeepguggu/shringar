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
    "title" => '<span class="span_img bill_invoice"></span>New Invoice',
    "name" => "invoice",
    "href" => site_url('invoice/new_invoice?tabs=1'),
    "class" => "first",
    'url' => 'invoice/new_invoice'
);
$tabs[] = array("index" => 2,
    "title" => '<span class="span_img bill_exchange"></span>Exchange',
    "name" => "exchange",
    "href" => site_url('invoice/exchange?tabs=1'),
    "class" => "",
    'url' => 'invoice/exchange'
);
/*$tabs[] = array("index"=>4,
				"title"=> '<span class="span_img bill_buy"></span>Buy', 			
				"name"=>"purchase_bill", 		
				"href"=>site_url('billing/purchase_bill?tabs=1'), 
				"class"=>"",
                'url' => 'billing/invoice'
			);
$tabs[] = array("index"=>5, 
				"title"=> '<span class="span_img bill_co"></span>Customer Order', 			
				"name"=>"customer_order", 		
				"href"=>site_url('billing/customer_order?tabs=1'), 
				"class"=>""
			);*/
$tabs[] = array("index" => 3,
    "title" => '<span class="span_img bill_search_invoice"></span>Search Invoices',
    "name" => "search",
    "href" => site_url('invoice/search?tabs=1'),
    "class" => "last",
    'url' => 'invoice/search'
);
/*$tabs[] = array("index"=>7,
				"title"=> "Invoice Report", 
				"name"=>"report", 	
				"href"=>site_url('billing/invoice_report?tabs=1'), 
				"class"=>"last"
			);

$tabs[] = array("index"=>7, 
                "title"=> "Old Gold Report", 
                "name"=>"report",     
                "href"=>site_url('billing/old_gold_report?tabs=1'), 
                "class"=>"last"
            );*/
?>
<?php if ($ajax === false): ?>
<div id="tabs" class="ui-tabs">
    <ul class="ui-tabs-nav">
        <li class="hidden"><a href="#tabs-1">Preloaded</a></li>
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
        <h2>Billing Section</h2>

        <div style="margin-left:20px;">
            <ul>
                <li>You can create your invoice</li>
                <li>Exchange items</li>
                <li>Search Old Invoices</li>
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
    $(function () {
        tabs.bind({
            tabsId:'#tabs'
        });
    });
</script>
<?php else: echo $output; endif; ?>