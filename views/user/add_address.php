<?php 
$this->dispatch("layout/header");

$validate=array(
		"name"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"address1"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"phone"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"city"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"country"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"state"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"zipcode"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)
);


$name=$this->get_variable("name");
$address1=$this->get_variable("address1");
$address2=$this->get_variable("address2");
$phone=$this->get_variable("phoneno");
$city=$this->get_variable("city");
$country=$this->get_variable("country");
$state=$this->get_variable("state");
$zipcode=$this->get_variable("zipcode");

if($country =='')
$country=Settings::get_instance()->read('country');
?>


<style type="text/css">

.selectboxit-option, .selectboxit-optgroup-header{width: 220px !important;}
.selectboxit-container .selectboxit{width: 220px !important;}

</style>

   	<div class="container mtop-20">
    	
<?php $this->dispatch("layout/login_left");?>

	<div class="accountData contentLeft">
				
<?php 
      $form=$this->create_form();
      $form->start("add_new_address",$this->make_url("user/add_address"),"post",$validate);
?>

		<div style="width:74%;float:left;">
           	 <h1 class="titleh1"><?php echo $this->get_label('add new address');?></h1>
         </div>
				
			 <div style="width:26%;float:left;">
                
                 <div class="titleh1" style="margin-top:5px;padding-bottom:2px;"> <?php echo $this->get_label('compulsory message');?></div>
            
                </div>
			 
            
            <div style="width:50%;float:left;"> 
            
             <div class="label_div">
           		 <strong><?php echo $this->get_label('name');?></strong> <span class="mandatory">*</span>
            </div>
            
              <div class="label_text_field">
           		 <input  name="name" id="name" type="text" value="<?php echo $name;?>" class="textStyle2">
            </div>
            
            <div class="label_div">
           		 <strong><?php echo $this->get_label('address1');?></strong> <span class="mandatory">*</span>
            </div>
            
             <div class="label_text_field">
           		<input name="address1" id="address1" type="text" value="<?php echo $address1;?>" class="textStyle2">
            </div>
            
            
            <div class="label_div">
           		 <strong><?php echo $this->get_label('address2');?></strong>
            </div>
            
              <div class="label_text_field">
           		<input name="address2" id="address2" type="text" value="<?php echo $address2;?>" class="textStyle2">
            </div>
            
            
            <div class="label_div">
           		 <strong><?php echo $this->get_label('phone no');?></strong> <span class="mandatory">*</span>
            </div>
            
              <div class="label_text_field">
           		<input name="phone" id="phone" type="text" value="<?php echo $phone;?>" class="textStyle2">
            </div>
            
            </div>
            
            
             <div style="width:50%;float:left;"> 
            
            
            
            <div class="label_div">
           		 <strong><?php echo $this->get_label('country');?></strong> <span class="mandatory">*</span>
            </div>
            
              <div class="label_text_field">
           		<select name="country" id="country" style="width: 338px;">
                    <option value="" selected="selected"><?php echo $this->get_label('select');?></option>
                       <?php 
                       $countries=$this->get_result('countries');
   					   foreach($countries as $key=>$row)
    				   {?>
                       <option value="<?php echo $row['ccode']; ?>" <?php if($row['ccode'] == $country){?>selected<?php }?>><?php echo $row['cname']; ?></option>
                       <?php } ?> 
                </select> 
            </div>
            
            
            
            <div class="label_div">
           		 <strong><?php echo $this->get_label('state');?></strong> <span class="mandatory">*</span>
            </div>
            
              <div class="label_text_field">
           		<input name="state" id="state" type="text" value="<?php echo $state;?>" class="textStyle2">
            </div>
            
            
             <div class="label_div">
           		 <strong><?php echo $this->get_label('city');?></strong> <span class="mandatory">*</span>
            </div>
            
              <div class="label_text_field">
           		<input name="city" id="city" type="text" value="<?php echo $city;?>" class="textStyle2">
            </div>
            
            
            
             <div class="label_div">
           		 <strong><?php echo $this->get_label('zip code');?></strong> <span class="mandatory">*</span>
            </div>
            
              <div class="label_text_field">
           		<input name="zipcode" id="zipcode" type="text" value="<?php echo $zipcode;?>" class="textStyle2">
            </div>
            
            </div>
            
            <div class="submit-btn-div">
             <input type="submit" name="submit"  value="<?php echo $this->get_label('save');?>" class="cartAddition">
            </div>

		
	<?php $form->end(); ?>
	
			
		</div>
</div>  
<?php $this->dispatch("layout/footer");?>