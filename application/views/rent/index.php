<?php
if (!isset($ajax))
{
    $ajax = false;
}
$cur_tab = 1;
if (!isset($tab))
{
    $tab = 'default';
}
$tabs = array();

$tabs[] = array("index" => 1,
    "title" => "MANAGE PRODUCTS",
    "name" => "manageProducts",
    "href" => site_url('rent/manageProducts?tabs=1'),
    "class" => "",
    'url' => 'rent/manageProducts'
);
$tabs[] = array("index" => 2,
    "title" => "MANAGE COMPONENTS",
    "name" => "manageComponents",
    "href" => site_url('rent/manageComponents?tabs=1'),
    "class" => "",
    'url' => 'rent/manageComponents'
);
$tabs[] = array("index" => 3,
    "title" => "MANAGE CATEGORY",
    "name" => "manageCategory",
    "href" => site_url('rent/manageCategory?tabs=1'),
    "class" => "",
    'url' => 'rent/manageCategory'
);
$tabs[] = array("index" => 4,
    "title" => "Bookings",
    "name" => "bookings",
    "href" => site_url('rent/manageOrders?tabs=1'),
    "class" => "",
    'url' => 'rent/manageOrders'
);
$tabs[] = array("index" => 5,
    "title" => "Pickup",
    "name" => "pickup",
    "href" => site_url('rent/pickup?tabs=1'),
    "class" => "last",
    'url' => 'rent/pickup'
);
$tabs[] = array("index" => 6,
    "title" => "Reports",
    "name" => "reports",
    "href" => site_url('rent/transactionReports?tabs=1'),
    "class" => "last",
    'url' => 'rent/transactionReports'
);
$tabs[] = array("index" => 7,
    "title" => "Invoice",
    "name" => "invoice",
    "href" => site_url('rent/invoice?tabs=1'),
    "class" => "last",
    'url' => 'rent/invoice'
);
$tabs[] = array("index" => 8,
    "title" => "Stock",
    "name" => "stock",
    "href" => site_url('rent/displayComponentsStock?tabs=1'),
    "class" => "first",
    'url' => 'rent/displayComponentsStock'
);
        
if ($ajax === false)
{

    ?>
    <div id="tabs">
        <ul>
            <li style="display:none; width:0px; height:0px;"><a href="#tabs-1">Preloaded</a></li>
            <?php
            foreach($tabs as $t){
			 echo '<li class="'.(($t['name'] == $tab)?'ui-tabs-selected ':'').$t['class'].'" url="'.$t['url'].'">';
			 if($t['name'] == $tab){
				 echo '<a href="#ui-tabs-'.$t['index'].'">'.$t['title'].'</a>'; 
			 }else{
				  echo '<a href="'.$t['href'].'">'.$t['title'].'</a>';
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
        foreach ($tabs as $t)
        {

            if ($tab == $t['name'])
            {
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
            tabsId : '#tabs'
        });
    });
</script>
    <?php
} else
{
    echo $output;
}
?>