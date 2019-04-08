<?php 
$this->dispatch("layout/header/1/_11");

$validate=array(
	"category"=>array(
			"notNull"=>array($this->get_message("mandatory"))
	)
);

$pid=$this->get_variable('pid');
$category=$this->get_variable('category');

$form=$this->create_form();
$form->start("add_category",$this->make_url("category/add"),"post",$validate);?>


<div class="sub_menu"><?php echo $this->get_label('add cat');?></div>


<table style="width: 100%">

  <tr>
    <td></td>
    <td >&nbsp;<input type="hidden" name="pid" id="pid" value="<?php echo $pid; ?>"/></td>
    <td><?php echo $this->get_label('compulsory message');?></td>
    <td>&nbsp;</td>
  </tr>
  
    <tr><td colspan="4" height="10px"></td></tr>
  
  
  <tr>
    <td></td>
    <td width="150px"><?php echo $this->get_label('cat name'); ?></td>
    <td><input name="category" type="text" id="category" value="<?php echo $category; ?>" class="textStylePadding" placeholder="<?php echo $this->get_label('cat name'); ?>"><span class="mandatory">*</span></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr><td colspan="4" height="10px"></td></tr>
    
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td><input type="submit" name="Submit" value="<?php echo $this->get_label('submit'); ?>" class="btn btn-default"></td>
    <td>&nbsp;</td>
  </tr>  
</table>
<?php $form->end(); ?>
<?php $this->dispatch("layout/footer");?>