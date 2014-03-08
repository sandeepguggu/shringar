<script>
$(function() {
        var dates = $( "#from, #to" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 3,
                onSelect: function( selectedDate ) {
                        var option = this.id == "from" ? "minDate" : "maxDate",
                                instance = $( this ).data( "datepicker" ),
                                date = $.datepicker.parseDate(
                                        instance.settings.dateFormat ||
                                        $.datepicker._defaults.dateFormat,
                                        selectedDate, instance.settings );
                        dates.not( this ).datepicker( "option", option, date );
                }
        });
});

</script>
<div class="inventory-report">

	<!-- User Access Message -->
	<?php if (isset($access)): ?>
		<h3><?= $access ?></h3>
	<?php else: ?>
		<h3 class="pull-left">Report</h3>
		<br />
		<hr />

		<form class="form-horizontal">
                    <label for="from" style="display:inline;">From</label>
                    <input type="text" id="from" name="from" />
                    <label for="to" style="display:inline;">to</label>
                    <input type="text" id="to" name="to" />
                    <a id="reports" class="btn btn-primary">Generate Report</a>
                </form>
                    <span class="report-table"></span>
        <?php endif; ?>
<script>
    element.click('#reports',rent_products.displayReports);
    </script>



