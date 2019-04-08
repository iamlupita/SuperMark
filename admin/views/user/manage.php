<?php 
$this->dispatch("layout/header");

$status=$this->get_variable("status");
?>



<div class="sub_menu"><?php echo $this->get_label('manage user');?></div>



<div>
<?php 
$form=$this->create_form();
$form->start("manage",$this->make_url("user/manage"),"post");
?>
<table style="width: 100%;" cellpadding="0" cellspacing="0">
  <tr>
    <td ></td>
    <td colspan="3"><strong><?php echo $this->get_label('status');?></strong>&nbsp;
 <select name="status" id="status">
    <option value="-1" <?php if($status==-1){ echo "selected";}?>><?php echo $this->get_label('all'); ?></option>
    <option value="1"  <?php if($status==1){ echo "selected";}?>><?php echo $this->get_label('active'); ?></option>
    <option value="0"  <?php if($status==0){ echo "selected";}?>><?php echo $this->get_label('blocked'); ?></option>
    <option value="-2"  <?php if($status==-2){ echo "selected";}?>><?php echo $this->get_label('email not verified'); ?></option>
 </select>
  &nbsp;
  
   <input type="submit" name="search" id="search" value="<?php echo $this->get_label('go'); ?>" class="btn btn-default"/> 
    </td>
    <td ></td>
  </tr>
  <tr><td colspan="5" height="20px"></td></tr>
</table>
<?php $form->end(); ?>  
</div>



<table style="width: 100%;" class="data_table" cellpadding="0" cellspacing="0">
  


 
  <tr>
    <td class="dt_head_td" width="1%"></td>
    <td class="dt_head_td" width="30%"><?php echo $this->get_label('email'); ?></td>
    <td class="dt_head_td" width="20%"><?php echo $this->get_label('name'); ?></td>
    <td class="dt_head_td" width="13%"><?php echo $this->get_label('join date'); ?></td>
    <td class="dt_head_td" width="15%"><?php echo $this->get_label('status'); ?></td>
    <td class="dt_head_td" width="20%"><?php echo $this->get_label('actions'); ?></td>
    <td class="dt_head_td" width="1%"></td>
  </tr>
<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{
?>
  <tr <?php if($row['status']==0){ ?> class="dt_data_tr_inactive" <?php }else if($row['status']==1){?> class="dt_data_tr_active" <?php }
    else if($row['status']==-2){?> class="dt_data_tr_pending"<?php }?>  >
    <td class="dt_data_td"></td>
    <td class="dt_data_td"><a href="<?php echo $this->make_url("user/profile/$row[id]");?>"><?php echo $row['email']; ?></a></td>
    
   <td class="dt_data_td"><?php echo $row['name'];?></td>
 
   <td class="dt_data_td"><?php echo $this->get_date_format(3,$row['joindate']); ?></td>
   
   <td class="dt_data_td"><?php echo $this->get_user_status($row['status']);?></td>
   
     <td class="dt_data_td"> 
	<?php 
	if($row['status']==0 || $row['status']==-2) 
	{?>
	<a href="<?php echo $this->make_url("user/activate/".$row['id']."/".$status);?>"><img alt="<?php echo $this->get_label('activate'); ?>" src="images/activate.png" title="<?php echo $this->get_label('activate'); ?>" /></a> 
	<?php }
	else 
	{
		
		
		if(!DEMO_MODE ||(DEMO_MODE == TRUE && $row['id']!=1))
		{	
	?>
	<a href="<?php echo $this->make_url("user/block/".$row['id']."/".$status);?>"><img alt="<?php echo $this->get_label('block'); ?>" src="images/block.png" title="<?php echo $this->get_label('block'); ?>" /></a> 
	<?php 
		}
	}
	?> 
	&nbsp;<a href="<?php echo $this->make_url("user/delete/".$row['id']."/".$status);?>" 
	onclick="return confirm('<?php echo $this->get_message('delete user confirmation');?>');"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></a> 
	&nbsp;<a href="<?php echo $this->make_url("user/login/".$row['id']);?>" target="_blank"><img alt="<?php echo $this->get_label('login'); ?>" src="images/login.png" title="<?php echo $this->get_label('login'); ?>" /></a>
	</td>
    <td class="dt_data_td"></td>
  </tr>
   
  <tr><td colspan="5"></td></tr>
<?php 
} 
?>
<?php 
if(count($res)==0) 
{
?>
    <tr>
    <td class="dt_data_td border-bottom"></td>
    <td class="dt_data_td border-bottom" colspan="6"><?php echo $this->get_label('no record'); ?></td>
    </tr>
<?php 
}
else
{
?>
    <tr>
	<td class="dt_data_td border-bottom" colspan="7" align="center" ><?php echo $this->get_variable('pagination');?></td>
	</tr>
<?php 
}
?>
</table>

<?php $this->dispatch("layout/footer");?>