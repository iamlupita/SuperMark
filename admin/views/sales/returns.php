<?php 
$this->dispatch("layout/header/5/_52");
?>
<div class="sub_menu"><?php echo $this->get_label('manage returns');?></div>



<div style="height: 40px;">

<table style="width: 100%" cellpadding="0" cellspacing="0">
<tr>
 <td>
<?php 
$paramstatus=$this->get_variable("paramstatus");

$form=$this->create_form();
$form->start("manage",$this->make_url("sales/returns"),"post");
?> 
<?php echo $this->get_label('status'); ?>&nbsp;
 <select name="paramstatus" id="paramstatus" style="width: 50px !important;">
 <option value="0" <?php if($paramstatus==0){ echo "selected";}?>><?php echo $this->get_label('all'); ?></option>
 <option value="1"  <?php if($paramstatus==1){ echo "selected";}?>><?php echo $this->get_label('requested'); ?></option>
 <option value="2"  <?php if($paramstatus==2){ echo "selected";}?>><?php echo $this->get_label('approved'); ?></option>
 <option value="3"  <?php if($paramstatus==3){ echo "selected";}?>><?php echo $this->get_label('rejected'); ?></option>
 </select>

<input type="submit" name="search" id="search" value="<?php echo $this->get_label('go'); ?>" class="btn btn-default" style="margin-left: 20px;" />
<?php $form->end(); ?>  
 </td>
 </tr>
</table>
 
</div>













<table style="width: 100%" class="data_table">

  <tr>
    <td class="dt_head_td" width="15%"><?php echo $this->get_label('order id');?></td>
    <td class="dt_head_td" width="22%"><?php echo $this->get_label('user');?></td>
    <td class="dt_head_td" width="22%"><?php echo $this->get_label('reason');?></td>
    <td class="dt_head_td" width="15%"><?php echo $this->get_label('amount');?></td>
    <td class="dt_head_td" width="10%"><?php echo $this->get_label('status');?></td>
    <td class="dt_head_td" width="16%"><?php echo $this->get_label('action');?></td>
  </tr>  

<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{

?>
  <tr>
    <td class="dt_data_td">
 <a href="<?php echo $this->make_url('sales/details/').$row['order_id']; ?>">#<?php echo $row['order_id'];?></a>
 </td>
    
    
     <td class="dt_data_td">
  
  
  <?php 
$username=$this->get_item_client($row['id']);
if($username !=''){?>
<a href="<?php echo $this->make_url('user/profile/').$this->get_item_client_id($row['id']); ?>"><?php echo $username;?></a>
<?php }else{?>
<?php echo $this->get_label('deleted');?>
<?php }?>
  
  
    </td>
    
      <td class="dt_data_td">
   <?php echo $row['reason'];  ?>
    </td>
    
    
      <td class="dt_data_td">
   <?php if($row['amount'] >0){echo $this->get_money_format($row['amount']); }else{echo $this->get_label('na');} ?>
    </td>
    
    
    <td class="dt_data_td">
       <?php echo $this->get_return_status($row['stat']);?>
    </td>

<td class="dt_data_td"><a href="javascript:void(0);" onclick="edit_return_details(<?php echo $row['return_id'];?>)" style="padding-left: 10px;" ><img  src="images/edit.png" title="<?php echo $this->get_label('edit');?>" /></a>
<a href="javascript:void(0);" onclick="get_return_summary(<?php echo $row['return_id'];?>)" style="padding-left: 5px;" ><img  src="images/view.png" title="<?php echo $this->get_label('view details');?>" /></a>  
<a href="javascript:void(0);" onclick="get_shipment_details(<?php echo $row['shipment_id'];?>)" style="padding-left: 5px;" ><img  src="images/shipment.png" title="<?php echo $this->get_label('shipment details');?>" /></a></td>  
</tr>

<?php 
} 
?>
<?php 
if(count($res)==0) 
{
?>
  <tr>
    <td class="dt_data_td border-bottom" colspan="6"><?php echo $this->get_label('no record'); ?></td>
  </tr>
<?php 
} 
else
{
?>
   <tr>
    <td class="dt_data_td border-bottom" colspan="6" align="center"><?php echo $this->get_variable('pagination');?></td>
   </tr>
<?php 
}
?>
</table>

<script type="text/javascript">
function edit_return_details(id)
{
	
	if(id!=""){

		$(".popup-outer").show();
		$("#editreturn_div").html('<img src="images/loading1.gif" class="loading-ajax">');
    	 
	 $.ajax({
			type: "GET",
			url: "<?php echo $this->make_url("sales/edit_return_details/");?>"+id+"/0/"+<?php echo $paramstatus;?>,
			/*data: "id="+id,*/
			success: function(response)
				{
				  $("#editreturn_div").html(response);

				  $("#status").selectBoxIt();
				}
	 });
}

}

function get_return_summary(id)
{
	
	if(id!=""){

		$("#editdiv").show();
		$("#return_details_div").html('<img src="images/loading1.gif" class="loading-ajax">');
    	 
	 $.ajax({
			type: "GET",
			url: "<?php echo $this->make_url("sales/get_return_summary/");?>"+id,
			/*data: "id="+id,*/
			success: function(response)
				{
				  $("#return_details_div").html(response);

				}
	 });
}

}



function get_shipment_details(id)
{
	if(id!=""){

		$("#editdiv").show();
		$("#return_details_div").html('<img src="images/loading1.gif" class="loading-ajax">');
    	 
	 $.ajax({
			type: "GET",
			url: "<?php echo $this->make_url("sales/get_shipment_details/");?>"+id,
			/*data: "id="+id,*/
			success: function(response)
				{
				  $("#return_details_div").html(response);

				}
	 });
}
	
}
</script>

<div id="editdiv" style="display:none ;">
<div class="behind_div">
<div class="popup" id="return_details_div"></div>
</div>
</div>



<div class="popup-outer" style="display:none ;">
<div class="behind_div">
<div class="popup" id="editreturn_div"></div>
</div>
</div> 
<?php $this->dispatch("layout/footer");?>