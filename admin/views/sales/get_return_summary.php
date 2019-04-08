<div class="sub_menu"><?php echo $this->get_label('return details');?>
<a class="closeButton" onclick="$('#editdiv').hide();" style="position: relative;float: right;top: -5px;">X</a>

</div>

 <?php 
    $res=$this->get_result('res');
    if(count($res)==0)
    {
    	echo $this->get_label('no record');
    }
    else{
    foreach($res as $key=>$row)
    {
?>
        
<table style="width: 100%;padding-left: 20px;">
 
   <tr>
    <td style="width:20%;"><?php echo $this->get_label('order id');?></td>
    <td style="width: 10%;">:</td>
	<td>#<?php echo $this->get_orderid_from_orderitemid($row['order_item_id']);?></td>
  </tr>
   
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('user');?></td>
    <td>:</td>
	<td>
	<?php 
	$username=$this->get_user_email($this->get_userid_from_orderid($this->get_orderid_from_orderitemid($row['order_item_id'])));
	if($username !='')
	echo $username;
	else
	echo $this->get_label('deleted');
	?>   	
	</td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('reason');?></td>
    <td>:</td>
	<td><?php echo $row['reason'];?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('quantity');?></td>
    <td>:</td>
	<td><?php if($row['quantity']!=0){ echo $row['quantity'];}?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('amount');?></td>
    <td>:</td>
	<td><?php if($row['solved_date'] >0){echo $this->get_money_format($row['amount']);}else{echo $this->get_label('na');}?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('requested on');?></td>
    <td>:</td>
	<td><?php echo $this->get_date_format(3,$row['issue_date']);?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('resolved on');?></td>
    <td>:</td>
	<td><?php if($row['solved_date'] >0){ echo $this->get_date_format(3,$row['solved_date']);}else{echo $this->get_label('na');}?></td>
  </tr>
  
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('remarks');?></td>
    <td>:</td>
	<td><?php if($row['admin_remarks'] !=''){echo $row['admin_remarks'];}else{echo $this->get_label('na');}?>
	</td>
  </tr>
  
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('status');?></td>
    <td>:</td>
	<td><?php echo $this->get_return_status($row['status']);?>
	</td>
  </tr>
  
  <tr><td colspan="2" style="height:25px !important;"></td></tr>

  </table> 
<?php }}?>  