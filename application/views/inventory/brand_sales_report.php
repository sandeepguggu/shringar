<div class="content-header">
    <h3>BRAND SALES REPORT</h3>
</div>

<div class="search-filter block">
    <div class=" row-fluid">

        <form id="brand_sales_form" class="" action="<?php echo site_url('inventory/get_brand_sales_excel_report'); ?>" method="POST">

            <label class="span2">
                <span>From</span>
                <input type="text" name="reports_date_from" id="reports_date_from" value="<?php echo isset($_REQUEST['reports_date_from']) ? $_REQUEST['reports_date_from'] : ''; ?>">
            </label>
            <label class="span2">
                <span>To</span>
                <input type="text" name="reports_date_to" id="reports_date_to" value="<?php echo isset($_REQUEST['reports_date_to']) ? $_REQUEST['reports_date_to'] : ''; ?>">
            </label>  
            <label class="span3">
                <span>Brand</span>
                <select name = "reports_brand_id" id="reports_brand_id">
                    <option value="0">All</option>
                    <?php
                    if (isset($brands)) {
                        foreach ($brands as $c) {
                            $selected = '';
                            if (isset($_REQUEST['reports_brand_id']) && $_REQUEST['reports_brand_id'] == $c['id']) {
                                $selected = ' selected ';
                            }
                            echo '<option value="' . $c['id'] . '" ' . $selected . '>' . $c['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
             </label>      
            <label class="span2">
                <span class="search-filter-search-label">X</span>
                <button type="button" id="filter_reports_btn" class="btn btn-primary">Submit</button>
            </label>

        </form>

    </div>
</div>





    <div class="content-subject" id="reports_grid">

        <?php if (isset($brand_sales_report) && is_array($brand_sales_report) && count($brand_sales_report)): 
            echo "Total Records: ".$total;
        ?>

        
        <button id="vat_excel_report" class="btn btn-primary" style="float:right">Export to Excel</button>            
        <span style="float:right; margin-right:35px;">Total VAT : <?php echo $total_vat; ?></span>
        <span style="float:right; margin-right:35px;">Total Amount : <?php echo $total_amount; ?></span>
        <span style="float:right; margin-right:35px;">Total Quantity : <?php echo $total_quantity; ?></span>
       
       <table class="table table-striped table-bordered" width="100%" style="margin-top:20px">
        <tr>
            <th>BILL ITEM NO / REF NO</th>
            <th>DATE</th>            
            <th>PRODUCT NAME</th>      
            <th>BRAND</th>
            <th>QTY</th>
            <th>AMOUNT</th>            
            <th>VAT</th>            
        </tr>
        <?php foreach($brand_sales_report as $key => $record): ?>
            <tr>
            <?php foreach($record as $value): ?>
                <td><?php echo $value; ?></td>
            <?php endforeach; ?>               
            </tr>
        <?php endforeach; ?>
        </table>
        <?php elseif(isset($brand_sales_report) && !is_array($brand_sales_report)): 
            echo "No records"
        ?>
        <?php endif; ?>
    </div>

<?php if (isset($brand_sales_report) && is_array($brand_sales_report) && count($brand_sales_report)): ?>
    <div class="pagination"><?php echo isset($links) ? $links : '';  ?></div>
<?php endif; ?>
        


<script type="text/javascript">
    $('#reports_date_from').datetimepicker({
        onClose:function (dateText, inst) {
            var endDateTextBox = $('#reports_date_to');
            if (endDateTextBox.val() != '') {
                var testStartDate = new Date(dateText);
                var testEndDate = new Date(endDateTextBox.val());
                if (testStartDate > testEndDate)
                    endDateTextBox.val('');
            }
            else {
                endDateTextBox.val('');
            }
        },
        
        onSelect:function (selectedDateTime) {
            var start = $(this).datetimepicker('getDate');
            $('#reports_date_to').datetimepicker('option', 'minDate', new Date(start.getTime()));
        }

    });
    $('#reports_date_to').datetimepicker({
        onClose:function (dateText, inst) {
            var startDateTextBox = $('#reports_date_from');
            if (startDateTextBox.val() != '') {
                var testStartDate = new Date(startDateTextBox.val());
                var testEndDate = new Date(dateText);
                if (testStartDate > testEndDate)
                    startDateTextBox.val('');
            }
            else {
                startDateTextBox.val('');
            }
        },
        onSelect:function (selectedDateTime) {
            var end = $(this).datetimepicker('getDate');
            $('#reports_date_from').datetimepicker('option', 'maxDate', new Date(end.getTime()));
        }
    });
    element.click('#filter_reports_btn', brand_sales_report.filter);
    element.click('#vat_excel_report', brand_sales_report.brandSalesExcelReport);
    element.click('.pagination a', brand_sales_report.getPageContent);
    //element.change('#reports-drop-down', reports.filter);
 $(".view_items").fancybox();
</script>             