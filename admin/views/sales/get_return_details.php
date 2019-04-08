<?php 
$return_items=$this->get_result('return_items');
if(count($return_items)>0)
{
?>

<div class="returndiv"><?php echo $this->get_label('return details');?></div>


<?php 
   
    foreach($return_items as $key=>$row)
    {
    
    ?>
    
    
    
<div class='popup-outer' id="edit-return-<?php echo $row['id'];?>" style="display:none ;">
<div class="behind_div">
<div class="popup">    
<iframe  src="<?php echo $this->make_url('sales/edit_return_details/'.$row['id'].'/1');?>" width="100%" height="100%" frameborder="0"></iframe>
</div>
</div>
</div>



<table class="shipping_table">

<tr>
	<td width="18%"><?php echo $this->get_label('return status');?></td>
	<td width="5%">:</td>
	<td width="30%"><strong style="font-weight: bold;"><?php echo $this->get_return_status($row['status']); ?></strong></td>
	<td width="25%"></td>
	<td width="5%"></td>
	<td width="15%" style="text-align: right;">
	
	<?php if($row['status'] !=2){?>
	<div style="width: 65px;margin-top: 10px;background-color:#ECECEC;" title="<?php echo $this->get_label('update return status');?>" class="shipdetailsdiv" onclick="edit_return_details(<?php echo $row['id'];?>);"><?php echo $this->get_label('update');?><img class="shipimage" src="images/edit.png" /></div>
	<?php }?>
	</td>
</tr>
	
	
	<tr>
	<td ><?php echo $this->get_label('quantity');?></td>
	<td >:</td>
	<td ><?php echo $row['quantity']; ?></td>
	<td ><?php echo $this->get_label('requested on');?></td>
	<td >:</td>
	<td ><?php echo $this->get_date_format(3,$row['issue_date']); ?></td>
</tr>
	
	<tr>
	<td ><?php echo $this->get_label('amount');?></td>
	<td >:</td>
	<td ><?php 
	if($row['amount'] >0)
	$amount=$this->get_money_format($row['amount']);
	else
	$amount=$this->get_label('na');
	
	
	if($row['solved_date'] >0){echo $amount;}else{echo $this->get_label('na');} ?></td>
	<td ><?php echo $this->get_label('resolved on');?></td>
	<td >:</td>
	<td ><?php if($row['solved_date'] >0){echo $this->get_date_format(3,$row['solved_date']);}else{echo $this->get_label('na');} ?></td>
</tr>
	
<tr>
	<td ><?php echo $this->get_label('reason');?></td>
	<td >:</td>
	<td ><?php echo $row['reason']; ?></td>
	<td ><?php echo $this->get_label('remarks');?></td>
	<td >:</td>
	<td ><?php if($row['admin_remarks'] !=''){echo $row['admin_remarks'];}else{echo $this->get_label('na');} ?></td>
</tr>

</table>

<?php } 
} ?>
<script type="text/javascript">
function edit_return_details(id)
{
	if(id !="")
	{
		$(".popup-outer").hide();
    	$("#edit-return-"+id).show();
	}
}
</script>