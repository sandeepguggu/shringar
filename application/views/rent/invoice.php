<div class="category">
    <h3>Pickup</h3>
   
    <div class="invoice_search">
        <div class="ui-widget">
            <label style="width:250px;" for="search_invoice_search"> Booking Id/Pick Up Id: </label>
            <input id="invoiceId" style="margin-bottom:0px;">&nbsp;&nbsp;<a class="btn btn-primary" id="invoiceSearch">Booking Details</a>
            <a href="<?php echo site_url('rent/viewbookings?ordertype=3'); ?>" class="btn btn-primary pull-right" id="vendor_add_btn">View All Bookings</a>
        </div>
         
    </div>
    <div id="InvoiceData">
        
    </div>
    
</div>
<script type="text/javascript">
     element.click('#invoiceSearch',rent_products.displayInvoice);

</script>