<?php 
$this->dispatch("layout/header/6/_62");
$id=$this->get_variable('id');
$disp_cat=$this->get_variable('disp_cat');
?>
<table >
<tr><td style="font-size: 12px;font-weight: bold;"><?php echo $this->get_message("custom field already exist");?></td></tr><tr><td>&nbsp;</td></tr>
<tr>
<td><a href="<?php echo $this->make_url("custom/deletegroup/".$id."/".$disp_cat."/1");?>"><?php echo $this->get_label('Confirm delete');?></a></td>
</tr>
</table>
<?php $this->dispatch("layout/footer");?>