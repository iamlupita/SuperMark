<?php 
$this->dispatch("layout/header/4/_34");
?>
<script type="text/javascript">
function termsUpdate()
{
	$('#terms').submit();
}
</script>

<script type="text/javascript" src='<?php echo BASE?>library/tinymce/jscripts/tiny_mce/tiny_mce.js'></script>
<script type="text/javascript">
	tinyMCE.init({
		mode :    "exact",                 // only one textarea id may be replaced
		plugins : "paste",
		elements: "description",    
		theme :   "simple",
		content_css:"<?php echo COMMON_DIR_PATH; ?>css/tinymce.css",
paste_preprocess : function(pl, o) {
			  o.content = strip_tags( o.content,'<b><u><i>' );
			},
	});

	</script>
<?php


$description=$this->get_variable('description');

$form=$this->create_form();
$form->start("terms",$this->make_url("system/about_us"),"post");?>


<table style="width: 100%" cellpadding="0" cellspacing="0">

<tr><td colspan="4" class="heading_td"><b><?php echo $this->get_label('about us');?></b></td></tr>

<tr><td colspan="4" height="10px"></td></tr>

  <tr>
    <td></td>
    <td ></td>
    <td><?php echo $this->get_label('compulsory message');?></td>
    <td>&nbsp;</td>
  </tr>
  
    <tr><td colspan="4" height="10px"></td></tr>
  
  
  <tr>
    <td></td>
    <td width="30px">&nbsp;</td>
    <td>
    <textarea name="description" id="description" rows="50" cols="80" class="textStylePadding"><?php echo $description; ?></textarea><span class="compulsory">*</span></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr><td colspan="4" height="10px"></td></tr>
    
  
  

  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td> 
    <?php if(DEMO_MODE) {?>
    <input type="button" name="tbutton" id="tbutton" value="<?php echo $this->get_label('update'); ?>" class="btn btn-default">
    <?php } else {?>
    <input type="button" name="tbutton" id="tbutton" value="<?php echo $this->get_label('update'); ?>" onclick="termsUpdate()" class="btn btn-default">
    <?php }?>
    </td>
    <td>&nbsp;</td>
  </tr>  
</table>
<?php $form->end(); ?>
<?php $this->dispatch("layout/footer");?>