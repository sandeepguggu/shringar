<div class="content-header">
    <h3>VAT REPORT</h3>
</div>

<div class="search-filter block">
    <div class=" row-fluid">

        <form id="vat_form" class="" action="<?php echo site_url('inventory/get_vat_excel_report'); ?>" method="POST">

            <label class="span2">
                <span>From</span>
                <input type="text" name="reports_date_from" id="reports_date_from" value="<?php echo isset($_REQUEST['reports_date_from']) ? $_REQUEST['reports_date_from'] : ''; ?>">
            </label>
            <label class="span2">
                <span>To</span>
                <input type="text" name="reports_date_to" id="reports_date_to" value="<?php echo isset($_REQUEST['reports_date_to']) ? $_REQUEST['reports_date_to'] : ''; ?>">
            </label>        
            <label class="span2">
                <span class="search-filter-search-label">X</span>
                <button type="button" id="filter_reports_btn" class="btn btn-primary">Submit</button>
            </label>

        </form>

    </div>
</div>





	<div class="content-subject" id="reports_grid">

		<?php if (isset($vat_report) && isset($vat_percentages) && is_array($vat_report) && count($vat_report)): 
			echo "Total Records: ".$total;
		?>
        
        <button id="vat_excel_report" class="btn btn-primary" style="float:right">Export to Excel</button>
        <?php foreach($vat_percentages as $i => $vat) :?>
              <span style="float:right; margin-right:35px;">Total Sales @ <?php echo $vat; ?>: <?php echo $gross_sales[$vat]; ?></span>
              <span style="float:right; margin-right:35px;">Total VAT @ <?php echo $vat; ?>: <?php echo $vat_amount[$vat]; ?></span>
        <?php endforeach; ?>
        <span style="float:right; margin-right:35px;">Total Sales : <?php echo $total_amount; ?></span>
       
	   <table class="table table-striped" width="100%" style="margin-top:20px">
		<tr>
			<th>BILL NO / REF NO</th>
			<th>DATE</th>
			<th>TOTAL SALES</th>
			<?php foreach($vat_percentages as $vat) :?>
				  <th>GROSS SALES @ <?php echo $vat?></th>
				  <th>VAT @ <?php echo $vat?></th>
		  	<?php endforeach; ?>
		  	<th></th>		
		</tr>
		<?php foreach($vat_report as $key => $record): ?>
			<tr>
			<?php foreach($record as $value): ?>
				<td><?php echo $value; ?></td>
			<?php endforeach; ?>
				<td>
					<a href="<?php echo site_url(); ?>/billing/get_bill_items_info?ajax=1&amp;id=<?php echo $record['id']; ?>" class="btn btn-primary view_items fancybox action-btn">
						<i class="icon-info-sign icon-white"></i>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php elseif(isset($vat_report) && isset($vat_percentages) && !is_array($vat_report)): 
			echo "No records"
		?>
		<?php endif; ?>
	</div>


<?php if (isset($vat_report) && isset($vat_percentages) && is_array($vat_report) && count($vat_report)): ?>
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
    element.click('#filter_reports_btn', vat_report.filter);
    element.click('#vat_excel_report', vat_report.vatExcelReport);
    element.click('.pagination a', vat_report.getPageContent);
    //element.change('#reports-drop-down', reports.filter);
 $(".view_items").fancybox();
</script>			  