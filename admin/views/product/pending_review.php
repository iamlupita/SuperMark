<?php $this->dispatch("layout/header/8/_08");?>
<div class="sub_menu"><?php echo $this->get_label('pending reviews');?></div>

<table style="width: 100%" class="data_table" cellpadding="0" cellspacing="0">
<tr >
<td class="dt_head_td" width="40%"><?php echo $this->get_label('item name');?></td>
<td class="dt_head_td" width="18%"><?php echo $this->get_label('pending reviews');?></td>
<td class="dt_head_td" width="10%"><?php echo $this->get_label('actions');?></td>
</tr>  

<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{

?>
  <tr>
    <td class="dt_data_td">
    
    <div class="productNameBanner" style="width: 300px;">
    <a href="<?php echo $this->make_url("product/details/".$row['id']);?>"><?php echo $row['name']; ?></a>
	</div>
    </td>
    <td class="dt_data_td"><?php echo $row['count']; ?></td>
    <td class="dt_data_td"><a href="<?php echo $this->make_url("product/reviews/".$row['id']);?>"><?php echo $this->get_label('details'); ?></a></td>
</tr>

 
<?php 
} 
?>
<?php if(count($res)==0) {?>
<tr><td class="dt_data_td border-bottom" colspan="3"><?php echo $this->get_label('no record'); ?></td></tr>
<?php } 
else
{?>
   <tr>
   <td class="dt_data_td border-bottom" colspan="3" align="center"><?php echo $this->get_variable('pagination');?></td>
   </tr>
<?php }?>
</table>
<?php $this->dispatch("layout/footer");?>