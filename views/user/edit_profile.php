<?php 
$this->dispatch("layout/header");

$validate=array(
		"name"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"email"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"email"=>array(
				"isEmail"=>array($this->get_message("mandatory"))
		)
);

?>

<div class="container mtop-20">

<?php $this->dispatch("layout/login_left");?>

<div class="accountData contentLeft">
                
 <?php 
        $form=$this->create_form();
        $form->start("edit_new_address",$this->make_url("user/edit_profile"),"post",$validate);
 ?>            
 
 			<div style="width:74%;float:left;">  
				<h1 class="titleh1t30"><?php echo $this->get_label('personal information');?></h1>
            </div>
			
			<div style="width:26%;float:left;">
                 <div class="titleh1 profile_mandatory_warning"> <?php echo $this->get_label('compulsory message');?></div>
            </div>
                
            <div class="personal-info-label">
           		 <strong><?php echo $this->get_label('email');?></strong>
            </div>
            
              <div class="personal-info-label-text">
           		 <input name="email" id="email" type="text" value="<?php echo $this->get_variable("email");?>" class="textStyle1" readonly="readonly" style="background-color:#e5e5e5;">
            </div>
            
            
            
              <div class="personal-info-label">
           		 <strong><?php echo $this->get_label('name');?></strong><span class="mandatory_new">*</span>
            </div>
            
              <div class="personal-info-label-text">
           		 <input  name="name" id="name" type="text" value="<?php echo $this->get_variable("name");?>" class="textStyle1">
            </div>
            
            <div class="personal-info-submit">
           		 <input type="submit" name="submit"  value="<?php echo $this->get_label('Update');?>" class="cartAddition">
            </div>

<?php $form->end(); ?>
		
				</div>
    </div>
    
<?php $this->dispatch("layout/footer");?>