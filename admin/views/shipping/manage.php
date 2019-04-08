<?php $this->dispatch("layout/header/2/_22");?>
<div class="sub_menu"><?php echo $this->get_label('manage shipping companies');?></div>


<table style="width: 100%" class="data_table" cellpadding="0" cellspacing="0">


  <tr >
    <td class="dt_head_td"></td>
    <td class="dt_head_td" width="35%"><?php echo $this->get_label('shipping company');?></td>
    <td class="dt_head_td" width="24%"><?php echo $this->get_label('tracking url');?></td>
    <td class="dt_head_td" width="10%"><?php echo $this->get_label('status');?></td>
    
    <td class="dt_head_td" width="30%"><?php echo $this->get_label('actions');?></td>
    <td class="dt_head_td"></td>
  </tr>
  
<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{?>
  <tr <?php if($row['status']==0){ ?> class="dt_data_tr_inactive" <?php }else if($row['status']==1){?> class="dt_data_tr_active" <?php }?>>
    <td class="dt_data_td"></td>
    <td class="dt_data_td"><?php echo $row['name'];?></td>

    <td class="dt_data_td"><?php echo $row['url'];?></td>
        
    <td class="dt_data_td"><?php if($row['status']==1 ) echo $this->get_label('active'); else echo $this->get_label('inactive'); ?></td>
    
    <td class="dt_data_td">    
    
    <a href="<?php echo $this->make_url("shipping/edit/".$row['id']);?>"><img alt="<?php echo $this->get_label('edit'); ?>" src="images/edit.png" title="<?php echo $this->get_label('edit'); ?>" /></a>  
    <?php 
    if($row['status']==0) 
    { 
    ?>
    &nbsp;<a href="<?php echo $this->make_url("shipping/activate/".$row['id']);?>"><img alt="<?php echo $this->get_label('activate'); ?>" src="images/activate.png" title="<?php echo $this->get_label('activate'); ?>" /></a> 
    <?php 
    }
    else
    { 
    ?>
    &nbsp;<a href="<?php echo $this->make_url("shipping/deactivate/".$row['id']);?>"><img alt="<?php echo $this->get_label('deactivate'); ?>" src="images/block.png" title="<?php echo $this->get_label('deactivate'); ?>" /></a>
    <?php 
    }
    ?>
    &nbsp;<a href="<?php echo $this->make_url("shipping/delete/".$row['id']);?>" onclick="return confirm('<?php echo $this->get_message('confirm shipping company delete'); ?>');"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></a>
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
    <td class="dt_data_td border-bottom"></td>
    <td class="dt_data_td border-bottom" colspan="5"><?php echo $this->get_label('no record'); ?></td>
  </tr>
<?php 
} 
else
{
?>
<tr>
<td class="dt_data_td border-bottom" colspan="5" align="center"><?php echo $this->get_variable('pagination');?></td>
</tr>
<?php
}
?>
</table>

<?php $this->dispatch("layout/footer");?>