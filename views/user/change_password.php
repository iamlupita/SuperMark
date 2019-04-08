<?php 
$this->dispatch("layout/header");
?>
<?php
$validate=array(
	"current_pwd"=>array(
			"notNull"=>array($this->get_message("mandatory"))
			),
	"pwd"=>array(
			"notNull"=>array($this->get_message("mandatory")),
			"minLength"=>array($this->get_variable('min_pass_len'),$this->get_message("password length"))
			),
	"rpwd"=>array(
			"notNull"=>array($this->get_message("mandatory")),
			"isSame"=>array('pwd',$this->get_message("password mismatch"))
			)
	);
$form=$this->create_form();
$form->start("change_password",$this->make_url("user/change_password"),"post",$validate); ?>
            
   	<div class="container mtop-20">
        
<?php 
$this->dispatch("layout/login_left");
?>
			    <div class="accountData contentLeft" style="margin-left:20px;">
				
                
                <div style="width:74%;float:left;">
				<h1 class="titleh1"><?php echo $this->get_label('change pwd');?></h1>
				</div>
                
                <div style="width:26%;float:left;">
                
                 <div class="titleh1" style="margin-top:5px;padding-bottom:2px;"> <?php echo $this->get_label('compulsory message');?></div>
            
                </div>
               
               
             <div style="width:80%;float:left;">
                
            
             <div class="password-label">
           		 <strong><?php echo $this->get_label('current pwd');?></strong>
            </div>
            
              <div class="password-label-text">
           		 <input class="textStyle" name="current_pwd" style="width:220px;" type="password" id="current_pwd" value="<?php echo $this->get_variable('current_pwd'); ?>"><span class="mandatory">*</span>
            </div>
            
              <div class="password-label">
           		 <strong><?php echo $this->get_label('new pwd');?></strong>
            </div>
            
              <div class="password-label-text">
           		<input class="textStyle" name="pwd" type="password" style="width:220px;" id="pwd" value="<?php echo $this->get_variable('pwd'); ?>"><span class="mandatory">*</span>
   				 <div class="warning">[<?php echo $this->get_label('minimum password length is',array('x'=>$this->get_variable('min_pass_len'))); ?>]</div>
    
      		</div>
            
            
         <div class="password-label">
           		 <strong><?php echo $this->get_label('confirm password');?></strong>
            </div>
            
             <div class="password-label-text">
           		<input class="textStyle" name="rpwd" type="password" style="width:220px;" id="rpwd" value="<?php echo $this->get_variable('rpwd'); ?>"><span class="mandatory">*</span>
      		</div>
            
            
			<div class="password-submit">
			   		<input type="submit" name="Submit" value="<?php echo $this->get_label('submit'); ?>" class="cartAddition">
            </div>

</div>
			
</div>
			
	<?php $form->end(); ?>
				
				
 </div>

<?php 
$this->dispatch("layout/footer");
?>
	
