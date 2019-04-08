<?php 
$this->dispatch("layout/header/5/_51");
?>
<style>
.dt_data_td .selectboxit
{
width: 115px !important;
}
.dt_data_td .selectboxit-option
{
width: 115px !important;
}


</style>
<script type="text/javascript">


function save_item_status(id)
{
	var selectVal = $('#order_status_'+id).val();
 	$.ajax(
			{
				type: "GET",
				url: "<?php echo $this->make_url("sales/update_status/");?>"+selectVal+"/"+id,
				success: function(msg)
					{
					
						 set_jnotice(1,'<?php echo $this->get_message('payment status updated');?>');
						 $("#statuschange_"+id).hide();

						 if(selectVal==1){
							 $("#status_"+id).show().html("<?php echo $this->get_label('pending payment');?>");
							 $("#status_"+id).css('color','#333333');
							 $("#status_edit_link_"+id).show();
						 }
						 else if(selectVal==2){
							 $("#status_"+id).show().html("<?php echo $this->get_label('payment completed');?>");
							 $("#status_"+id).css('color','green');
							 $("#status_edit_link_"+id).hide();
						 }
					}
			});
}



</script>
<div class="sub_menu"><?php echo $this->get_label('manage orders');?></div>


<div class="sub_menu" style="padding-top: 0px;height: 32px;background: none;">

<table style="width: 100%" cellpadding="0" cellspacing="0">
<tr>
 <td>
<?php 
$status=$this->get_variable("status");

$form=$this->create_form();
$form->start("manage",$this->make_url("sales/manage"),"post");
?> 


<?php echo $this->get_label('payment status'); ?>&nbsp;
 <select name="status" style="width: 50px !important;">
 <option value="0" <?php if($status==0){ echo "selected";}?>><?php echo $this->get_label('all'); ?></option>
 <option value="1"  <?php if($status==1){ echo "selected";}?>><?php echo $this->get_label('pending payment'); ?></option>
 <option value="2"  <?php if($status==2){ echo "selected";}?>><?php echo $this->get_label('payment completed'); ?></option>
 </select>


<input type="submit" name="search" id="search" value="<?php echo $this->get_label('go'); ?>" class="btn btn-default" style="margin-left: 20px;" />
<?php $form->end(); ?>  
 </td>
 </tr>
</table>
 
</div>



<table style="width: 100%" class="data_table">
 
  <tr >
    <td class="dt_head_td" width="10%"><?php echo $this->get_label('order id');?></td>
    <td class="dt_head_td" width="20%"><?php echo $this->get_label('user');?></td>
    <td class="dt_head_td" width="15%"><?php echo $this->get_label('order date');?></td>
    <td class="dt_head_td" width="15%"><?php echo $this->get_label('amount');?></td>
    <td class="dt_head_td" width="30%"><?php echo $this->get_label('status');?></td>
    <td class="dt_head_td" width="10%"><?php echo $this->get_label('action');?></td>
  </tr>  

<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{

?>
  <tr>
  <td  class="dt_data_td"><a href="<?php echo $this->make_url('sales/details/').$row['id']; ?>"><?php echo "#".$row['id'];?></a></td>
    <td class="dt_data_td">
    
   
   
<?php 
$username=$this->get_user_email($row['user_id']);
if($username !=''){?>
<a href="<?php echo $this->make_url('user/profile/').$row['user_id']; ?>"><?php echo $username;?></a>
<?php }else{?>
<?php echo $this->get_label('deleted');?>
<?php }?>
   
   
   
   
    </td>
  <td class="dt_data_td">
    
  <?php if($row['order_date']!=0){echo $this->get_date_format(3,$row['order_date']);}?>

    </td>
    
    
      <td class="dt_data_td">
    
    <?php echo $this->get_money_format($row['grand_cost']); ?>

    </td>
    

       
    <td class="dt_data_td"><span id="status_<?php  echo $row['id']?>"  <?php 
   if($row['status']==1){ ?>style="color: #333;"<?php }
    else if($row['status']==2){ ?>style="color: green;"<?php }?> ><?php echo $this->get_order_status($row['id'])?></span>
    
    <?php if($row['status']!=2){?>
    
    <span id="statuschange_<?php  echo $row['id']?>" style="display: none;">
    
    <select name="order_status_<?php  echo $row['id']?>" id="order_status_<?php  echo $row['id']?>">
    <option value="1" <?php if($row['status']==1){?> selected="selected" <?php }?>><?php echo $this->get_label('pending');?></option>
    <option value="2" <?php if($row['status']==2){?> selected="selected" <?php }?>><?php echo $this->get_label('completed');?></option>
    
    </select>
    
    <input onclick="save_item_status(<?php  echo $row['id']?>)" type="button" class="btn btn-default" value="<?php echo $this->get_label('go');?>">
    <input  onclick='$("#statuschange_<?php  echo $row['id']?>").hide();$("#status_<?php  echo $row['id']?>").show();$("#status_edit_link_<?php  echo $row['id']?>").show();' type="button" class="btn btn-default" value="X">
    </span>
    
    <a id="status_edit_link_<?php  echo $row['id']?>"  onclick='$("#status_<?php  echo $row['id']?>").hide();	$("#statuschange_<?php  echo $row['id']?>").show();$("#status_edit_link_<?php  echo $row['id']?>").hide();'> 
	<img alt='<?php  echo $this->get_label('edit')?>' src='images/edit.png' title='<?php  echo $this->get_label('edit status')?>' /></a>
    
    
    <?php }?>
    
    </td>
    
    <td class="dt_data_td">
    <a href="<?php echo $this->make_url('sales/details/'.$row['id']); ?>"><?php echo $this->get_label('details');?></a>
    </td>
    
    

</tr>

 
<tr id="tr_<?php echo $row['id']?>" style="display: none;"><td colspan="5" id="td_<?php echo $row['id']?>">   </td></tr>
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
<?php $this->dispatch("layout/footer");?>