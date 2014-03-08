<div id="print">
<table width="740" border="1" class="my-table1" align="center">
  <tr>
    <th height="71" colspan="3" align="center"><h2><strong>Costume Pick Up Receipt</strong></h2> </th>
  </tr>
  <tr>
    <td width="339" height="33" colspan="2">Invoice No. :&nbsp;<?php echo $billInfo['id']?><br/>
                                Delivery Date:&nbsp;<?php echo $billInfo['delivery_date'];?><br/>
                                No Of Days:&nbsp;<?php echo $billInfo['noofdays'];?><br/>

    </td>
    <td width="393">Date  :&nbsp;<?php echo date("d-m-Y")?></td>
  </tr>
  <tr>
    <td height="32" colspan="3">Name :&nbsp;<?php echo $customerInfo['lname']?></td>
  </tr>
  <tr>
    <th height="32" align="center">Component Name</th>
    <th height="32" align="center">Quantity</th>
    <th height="32" align="center">Rent Price</th>
  </tr>
  <?php
  foreach($itemInfo as $item){
  ?>
    <tr>
        <td height="32" align="center"><?php echo $item['name']."(".$item['product_name'].")";?></td>
        <td height="32" align="center"><?php echo $item['quantity']?></td>
        <td height="32" align="center"><?php echo $item['rent_price']?></td>
    </tr>
  <?php
  }
  ?>
  <tr>
    <td height="32" colspan="3">Rent Amount Recd. :&nbsp;Rs&nbsp;&nbsp;<?php echo $billInfo['total_rent']?><br/>
        Deposit Amount Recd. :&nbsp;Rs&nbsp;&nbsp;<?php echo $billInfo['deposit'];?>
    </td>

  </tr>

</table>
</div>
    <div class="my-block print-center">
    <input type="submit" class="btn primary" onclick="window.print();" value="Print">
    </div>

