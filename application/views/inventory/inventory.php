<table class="bordered-table zebra-striped" width="100%">
			<tr><th>S.No</th>
			   <th>Category</th>
			   <th>Total Products</th>
			   <th>Total Value</th>
			   </tr>
	  <?php $rwcnt=1; foreach($prod_count as $prod){ ?>
			  <tr>
			   <td><? echo $rwcnt?></td>
			   <td><? echo $prod['name']; ?> </td>
               <td><? if(!empty($prod['prod_count'])){echo $prod['prod_count'];} else {echo 0;} ?> </td>
               <td><?if(!empty($prod['total_value'])){echo $prod['total_value'];} else {echo 0;} ?> </td>
               </tr>
               <? } ?>
               </table> 
