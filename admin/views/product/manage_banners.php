<?php $this->dispatch("layout/header/8/_05");?>


<div class="sub_menu"><?php echo $this->get_label('manage banners');?></div>



<table style="width: 100%" class="data_table" cellpadding="0" cellspacing="0">
  <tr>
    <td class="dt_head_td" width="26%"><?php echo $this->get_label('banner name');?></td>
    <td class="dt_head_td" width="15%"><?php echo $this->get_label('banner for');?></td>
    <td class="dt_head_td" width="15%"><?php echo $this->get_label('type name');?></td>
    <td class="dt_head_td" width="20"><?php echo $this->get_label('image');?></td>
    <td class="dt_head_td" width="12%"><?php echo $this->get_label('status');?></td>
    
    <td class="dt_head_td" width="12%"><?php echo $this->get_label('actions');?></td>
  </tr>  

<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{

?>
  <tr <?php if($row['status']==0){ ?> class="dt_data_tr_inactive" <?php }else if($row['status']==1){?> class="dt_data_tr_active" <?php }?> >
    <td class="dt_data_td">
    
   <?php echo $row['name']; ?>

    </td>
    <td class="dt_data_td"><?php  if($row['type']==1){ echo $this->get_label('product');}
    else{ echo $this->get_label('category');}?></td>
    
    <td class="dt_data_td">
    <div class="productNameBanner">
    <?php  
    if($row['type']==1)
    echo $this->escape($this->get_product_name($row['type_id']));
    else
    echo $this->escape($this->get_category_name($row['type_id']));
    ?>
    </div>
    </td>
    
    
    <td class="dt_data_td">
    
    <?php 
    		//list($widthimage,$heightimage) = @getimagesize(DATA_DIR_PATH.'/banners/'.$row['image']);
			//$dimension=$this->get_image_dimension($widthimage,$heightimage,8);
			//$dimensionarray=explode('_',$dimension);
	?>
    
    
   <img title="<?php if($row['banner_type']==1){echo $this->get_label('big banner');}else if($row['banner_type']==2){echo $this->get_label('small banner');}else if($row['banner_type']==3){echo $this->get_label('horizontal banner');}?>" src="<?php echo DATA_DIR_PATH;?>banners/<?php echo $row['image'] ?>" <?php if($row['banner_type']==3){?>style="max-height: 30px;max-width:100px;"<?php }else{?>style="height: 30px;"<?php }?> />
    
    </td>
    
    <td class="dt_data_td">
    <?php  if($row['status']==0){  echo $this->get_label('inactive');  }else{ echo $this->get_label('active'); }?></td>
    
    
    <td class="dt_data_td">
    
   <?php  
    if($row['status']!=1) 
    	{
    	?>
    	<a href="<?php echo $this->make_url("product/activate_banner/".$row['id']);?>"><img alt="<?php echo $this->get_label('activate'); ?>" src="images/activate.png" title="<?php echo $this->get_label('activate'); ?>" /></a>
    	<?php 
    	}
	
	    if($row['status']!=0) 
	    {
	    ?><a href="<?php echo $this->make_url("product/block_banner/".$row['id']);?>"><img alt="<?php echo $this->get_label('block'); ?>" src="images/block.png" title="<?php echo $this->get_label('block'); ?>" /></a>
	    <?php 
	    }
	    ?> 
	    
  
  <a href="<?php echo $this->make_url("product/edit_banner/".$row['id']);?>"><img alt="<?php echo $this->get_label('edit'); ?>" src="images/edit.png" title="<?php echo $this->get_label('edit'); ?>" /></a>
  <a href="<?php echo $this->make_url("product/delete_banner/".$row['id']);?>" onclick="return confirm('Do you really want to delete the selected item?')"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></a>
 
  
  
  
  
  </td>
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
<?php $this->dispatch("layout/footer");?>