<?php 
$this->dispatch("layout/header/2/_24");

?>



<div class="sub_menu"><?php echo $this->get_label('manage shipping classes');?></div>


<table style="width: 100%" class="data_table" cellpadding="0" cellspacing="0">


  <tr >
    <td class="dt_head_td" width="55%"><?php echo $this->get_label('shipping class');?></td>
    <td class="dt_head_td" width="30%"><?php echo $this->get_label('actions');?></td>
    <td class="dt_head_td"></td>
  </tr>
  
<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{?>
  <tr  class="dt_data_tr_active">
    <td class="dt_data_td"><?php echo $row['class_name'];?></td>

   
    <td class="dt_data_td">
    
    <a href="<?php echo $this->make_url("shipping/edit_shipping_class/".$row['id']);?>"><img alt="<?php echo $this->get_label('edit'); ?>" src="images/edit.png" title="<?php echo $this->get_label('edit'); ?>" /></a>  
    &nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $this->make_url("shipping/delete_shipping_class/".$row['id']);?>" onclick="return confirm('<?php echo $this->get_message('confirm shipping class delete'); ?>');"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></a>
    </td>
    <td class="dt_data_td"></td>
  </tr>
<?php 
} 
?>
<?php 
if(count($res)==0) 
{
?>
  <tr>
    <td class="dt_data_td border-bottom" colspan="3"><?php echo $this->get_label('no record'); ?></td>
  </tr>
<?php 
} 
else
{
?>
<tr>
<td class="dt_data_td border-bottom" colspan="3" align="center"><?php echo $this->get_variable('pagination');?></td>
</tr>
<?php
}
?>
</table>

<?php $this->dispatch("layout/footer");?>