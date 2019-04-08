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
<div id="iframe_return_details1_<?php echo $row['id'];?>" style="display: none;">
<iframe src="<?php echo $this->make_url('order/edit_return_details/'.$row['id']).'/'.$this->get_variable('shipment_id').'/'.$this->get_variable('order_item_id');?>" width="100%" height="350px" frameborder="0"></iframe>
</div>


<table class="shipping_table">

<tr>
	<td width="15%"><?php echo $this->get_label('return status');?></td>
	<td width="5%">:</td>
	<td width="40%"><strong style="font-weight: bold;"><?php echo $this->get_return_status($row['status']); ?></strong></td>
	<td width="20%"></td>
	<td width="5%"></td>
	<td width="20%">
	

	<?php if($row['status']==1){
    if($this->get_variable('expired')==0){
    ?>
	<div style="width: 65px;background-color:#ECECEC;" title="<?php echo $this->get_label('update return status');?>" class="shipdetailsdiv" onclick="edit_return_details(<?php echo $row['id'];?>);"><?php echo $this->get_label('update');?><img class="shipimage" src="images/edit.png" /></div>
    <?php } ?> 
    &nbsp;&nbsp;<a href="<?php echo $this->make_url('order/delete_return_details/'.$row['id']);?>"><img  src="images/delete.png" title="<?php echo $this->get_label('delete');?>" /></a>
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

<?php }} ?>


<script type="text/javascript">
function edit_return_details(id)
{
	if(id!=""){
		popup(550,350,500,"#return_details_div");
		$("#return_details_div > #full_content").html($("#iframe_return_details1_"+id).html());
	}
}
</script>

<div class="popDetails">  	
<div id="return_details_div" >
<div class="contents" id="full_content"></div>
<a class="closeButton" onclick="popout()">X</a>
</div>
</div> 