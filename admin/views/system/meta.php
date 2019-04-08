<?php 
$this->dispatch("layout/header/4/_41");

$keyword=$this->get_variable('keyword');
$description=$this->get_variable('description');
?>

<script type="text/javascript">
function metaUpdate()
{
	$('#meta').submit();
}
</script>



<?php 




$form=$this->create_form();
$form->start("meta",$this->make_url("system/meta"),"post");?>


<div class="sub_menu"><?php echo $this->get_label('manage meta');?></div>


<table style="width: 100%" cellpadding="0" cellspacing="0">


  <tr>
    <td></td>
    <td width="150px"><?php echo $this->get_label('meta keyword'); ?><br>(<?php echo $this->get_label('comma seperated'); ?>)</td>
    <td><input name="keyword" type="text" id="keyword" value="<?php echo $keyword; ?>" size="30" class="textStylePadding"></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr><td colspan="4" height="10px"></td></tr>
    
  
  
    <tr>
    <td>&nbsp;</td>
    <td ><?php echo $this->get_label('meta description'); ?><br>(<?php echo $this->get_label('comma seperated'); ?>)</td>
    <td>
    <textarea name="description" id="description" rows="5" cols="43" class="textStylePadding"><?php echo $description; ?></textarea>
    </td>
    <td>&nbsp;</td>
  </tr>
  
  <tr><td colspan="4" height="10px"></td></tr>

  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>
    <?php if(DEMO_MODE) {?>
    <input type="button" name="mbutton" id="mbutton" value="<?php echo $this->get_label('update'); ?>" class="btn btn-default">
    <?php } else {?>
    <input type="button" name="mbutton" id="mbutton" value="<?php echo $this->get_label('update'); ?>" onclick="metaUpdate()" class="btn btn-default">
    <?php }?>
    </td>
    <td>&nbsp;</td>
  </tr>  
</table>
<?php $form->end(); ?>
<?php $this->dispatch("layout/footer");?>