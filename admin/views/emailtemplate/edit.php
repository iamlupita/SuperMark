<?php $this->dispatch("layout/header/3/_33");?>


<?php 
$validate=array(
		"sub"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)
);
		
		
		
		
		
$form=$this->create_form();
$form->start("item_submit",$this->make_url("emailtemplate/edit"),"post",$validate);?>



<div class="sub_menu"><?php echo $this->get_label('template edit');?></div>

<a href="<?php echo $this->make_url("emailtemplate/manage")?>" style="font-size: 13px;font-weight: bold;"><?php echo $this->get_label('manage email templates');?></a>

<div style="height: 15px"></div>

<table style="width: 100%;" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name="id" type="hidden" id="id" value="<?php echo $this->get_variable('id'); ?>" ></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="100%"><?php echo $this->get_label('template sub'); ?></td>
  </tr>
  
  <tr><td height="5px"></td></tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><input name="sub" type="text" id="sub" value="<?php echo $this->get_variable('sub'); ?>" size="50" class="textStylePadding" placeholder="<?php echo $this->get_label('template sub'); ?>"><span class="compulsory">*</span></td>
  </tr>
  
  
  
  <tr><td height="20px"></td></tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $this->get_label('template body'); ?></td>
  </tr>
    <tr><td height="5px"></td></tr>
  
  
  <tr>
    <td>&nbsp;</td>
    <td><?php 
				$oFCKeditor = new FCKeditor('body') ;
				$oFCKeditor->BasePath = LIB_DIR_PATH.'FCKeditor/' ;
				$oFCKeditor->Value = $this->get_variable('body');
				$oFCKeditor->Create() ;
			?>
	<br><span class="compulsory">*</span></td>
 </tr>
 
   <tr><td height="20px"></td></tr>
 
 
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="<?php echo $this->get_label('submit'); ?>" class="btn btn-default"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  

  
  
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $this->get_label('replace engine'); ?></td>
  </tr>
  
  
     <tr><td colspan="2" style="height:5px;"></td></tr>
  
  
 
  
  <?php if($this->get_variable('id') <=11 || $this->get_variable('id')==13) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace name'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  <?php } ?>
  
  
  
  <?php if($this->get_variable('id') ==1) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace email'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  <?php } ?>
  
  
  
    <?php if($this->get_variable('id') ==3) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace password'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  
  <?php } ?>
  
  
  
   <?php if($this->get_variable('id') ==4) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace status'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  
  <?php } ?>
  
  
  
  
  <?php if($this->get_variable('id') ==6 || $this->get_variable('id') ==7 || $this->get_variable('id') ==10 || $this->get_variable('id') ==13 || $this->get_variable('id') ==14) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace amount'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  <?php } ?>
  
  
  
   <?php if($this->get_variable('id') ==6 || $this->get_variable('id') ==7 || $this->get_variable('id') ==14) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace payment mode'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  <?php } ?>
  
  
  
  <?php if($this->get_variable('id') ==6 || $this->get_variable('id') ==13) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace transaction id'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  
  <?php } ?>
  
  
  
    <?php if($this->get_variable('id') ==8 || $this->get_variable('id') ==9 || $this->get_variable('id') ==10 || $this->get_variable('id') ==11 || $this->get_variable('id') ==15) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace item name'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  
  <?php } ?>
  
  
  
      <?php if($this->get_variable('id') ==8 || $this->get_variable('id') ==9 || $this->get_variable('id') ==10 || $this->get_variable('id') ==11 || $this->get_variable('id') ==15) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace quantity'); ?></td>
  </tr>
  
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  <?php } ?>
  
  
  
        <?php if($this->get_variable('id') ==8 || $this->get_variable('id') ==9) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace company'); ?></td>
  </tr>
  
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  <?php } ?>
  
  
    
        <?php if($this->get_variable('id') ==8 || $this->get_variable('id') ==9) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace tracking id'); ?></td>
  </tr>
  
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  
  <?php } ?>
  
  
  
   <?php if($this->get_variable('id') ==8 || $this->get_variable('id') ==9) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace tracking url'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  <?php } ?>
  
  
  
   <?php if($this->get_variable('id') ==10 || $this->get_variable('id') ==11) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace remarks'); ?></td>
  </tr>
  
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  <?php } ?>
  
  
  
   <?php if($this->get_variable('id') ==13 || $this->get_variable('id') ==14) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace payer email'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>
  
  
  
  <?php } ?>
  
     <?php if($this->get_variable('id') ==13 || $this->get_variable('id') ==14) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace ecode'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>

  
  <?php } ?>
  
  
  
      <?php if($this->get_variable('id') ==13) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace dbentry'); ?></td>
  </tr>
  
     <tr><td colspan="2" style="height:5px;"></td></tr>

  <?php } ?>
  
  
  
       <?php if($this->get_variable('id') ==15) {?>
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $this->get_label('replace reason'); ?></td>
  </tr>
  
       <tr><td colspan="2" style="height:5px;"></td></tr>
  
  
  <?php } ?>
   
  
</table>
<?php $form->end(); ?>
<?php $this->dispatch("layout/footer");?>