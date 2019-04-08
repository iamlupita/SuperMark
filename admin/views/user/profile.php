<?php 
$this->dispatch("layout/header");
$res=$this->get_result('res');
$value=$res[0];
$uid=$value['id'];
?>

<script type="text/javascript">
function show_details(id)
{
$('#stat1').css('background-color','#D8E9F8');
$('#stat2').css('background-color','#D8E9F8');
$('#stat'+id).css('background-color','#EEEEEE');

if(id==1)
{
	$('#item_table').show();
	$('#payment_table').hide();
}
else if(id==2)
{
	$('#item_table').hide();
	$('#payment_table').show();
}
}
</script>








<div class="sub_menu"><?php echo $this->get_label('user profile');?>
<span style="margin-left: 21px;">
 <?php 
 
    	if($value['status']==0 || $value['status']==-2) 
    	{
    	?>
    	<a href="<?php echo $this->make_url("user/activate/".$uid."/p");?>" style="margin-left: 10px;"><img alt="<?php echo $this->get_label('activate'); ?>" src="images/activate.png" title="<?php echo $this->get_label('activate'); ?>" /></a>
    	<?php 
    	}
	    else 
	    {
	    	if(!DEMO_MODE ||(DEMO_MODE == TRUE && $uid!=1))
		    {
		    ?><a href="<?php echo $this->make_url("user/block/".$uid."/p");?>" style="margin-left: 10px;"><img alt="<?php echo $this->get_label('block'); ?>" src="images/block.png" title="<?php echo $this->get_label('block'); ?>" /></a>
		    <?php 
		    }
	    }
?>
</span>

 <span style="margin-left: 10px;">  
    <a href="<?php echo $this->make_url("user/delete/".$uid."/".$value['status']);?>" 
	onclick="return confirm('<?php echo $this->get_message('delete user confirmation');?>');"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></a> 
  </span>
  
<span style="margin-left: 10px;"><a href="<?php echo $this->make_url("user/login/".$uid);?>"  target="_blank"><img alt="<?php echo $this->get_label('login'); ?>" src="images/login.png" title="<?php echo $this->get_label('login'); ?>" /></a></span>
    
  
    
    </div>



<table style="width: 400px;">

	
	
<tr>
<td><?php echo $this->get_label('name');?></td>
<td width="20px">:</td>
<td><?php echo $value['name'];?> &nbsp;</td>
</tr>
			
<tr><td colspan="3" height="10px"></td></tr>

	
<tr>
<td><?php echo $this->get_label('email');?></td>
<td width="20px">:</td>
<td><?php echo $value['email'];?> &nbsp;</td>
</tr>
			
<tr><td colspan="3" height="10px"></td></tr>
		
<tr><td><?php echo $this->get_label('status');?></td>
<td>:</td>
<td><?php echo $this->get_user_status($value['status']);?></td>
</tr>

<tr><td colspan="3" height="10px"></td></tr>
		
		
<tr><td><?php echo $this->get_label('registration time');?></td>
<td>:</td>
<td><?php echo $this->get_date_format(2,$value['joindate']);?></td>
</tr>
<tr><td colspan="3" height="10px"></td></tr>

</table>


<table  style="width: 100%;" cellpadding="0" cellspacing="0" >

 <tr><td colspan="4" height="20px"></td></tr>

 <tr>
 <td width="33%" class="td_tab" onclick="show_details(1);" id="stat1" style="margin-left: 15px;"><?php echo $this->get_label('purchase history'); ?></td>
 <td width="1px">&nbsp;</td>
 <td width="33%" class="td_tab" onclick="show_details(2);" id="stat2"><?php echo $this->get_label('wishlist'); ?></td>
 <td width="34%"></td>
 </tr>

 

 <tr id="payment_table">
 <td colspan="4">
  <iframe height="810px" width="100%"  frameborder="0" src="<?php echo $this->make_url("user/wishlist_items/".$uid)?>" ></iframe>
 
 </td>
 </tr>
 

  <tr id="item_table">
 <td colspan="4">
 <iframe height="810px" width="100%"  frameborder="0" src="<?php echo $this->make_url("user/order_items/".$uid)?>" ></iframe>
 

 </td></tr>
</table>	


<script type="text/javascript">
show_details(1);
</script>
<?php $this->dispatch("layout/footer");?>