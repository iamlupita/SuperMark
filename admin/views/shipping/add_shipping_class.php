<?php $this->dispatch("layout/header/2/_23");

$validate=array(
		
		"class_name"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"local_pickup_zipcodes"=>array(
						"notNull"=>array($this->get_message("mandatory"))
				),
		"local_shipping_type=>2"=>array(
				
			"local_price"=>array(
			"notNull"=>array($this->get_message("mandatory"))
		   )
	    ),
		"local_shipping_type=>3"=>array(
				
			"local_price"=>array(
			"notNull"=>array($this->get_message("mandatory"))
		  )
	   ),
		"nat_shipping_type=>2"=>array(
				
			"nat_price"=>array(
			"notNull"=>array($this->get_message("mandatory"))
		   )
	    ),
		"nat_shipping_type=>3"=>array(
				
			"nat_price"=>array(
			"notNull"=>array($this->get_message("mandatory"))
		  )
	   ),
		"inat_shipping_type=>2"=>array(
				
			"inat_price"=>array(
			"notNull"=>array($this->get_message("mandatory"))
		   )
	    ),
		"inat_shipping_type=>3"=>array(
				
			"inat_price"=>array(
			"notNull"=>array($this->get_message("mandatory"))
		  )
	   ),
	  
		
	);

$form=$this->create_form();
$form->start("add_shiiping_class",$this->make_url("shipping/add_shipping_class"),"post",$validate);
?>


<div class="sub_menu"><?php echo $this->get_label('add shipping class');?></div>



<table style="width: 100%">
  
  <tr>
    <td ></td>
    <td width="180px"><?php echo $this->get_label('shipping class name'); ?></td>
    <td><input name="class_name" type="text" id="class_name" class="textStylePadding" value="<?php echo $this->get_variable('class_name');?>"><span class="mandatory">*</span></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr><td colspan="4" height="15px"></td></tr> 
  
<tr><td colspan="4" class="heading_td"><strong><?php echo $this->get_label('local settings');?></strong></td></tr>
<tr><td colspan="4" height="10px"></td></tr>

  
  
  <tr id="local_pickup_zipcodes_tr">
    <td ></td>
    <td width="180px"><?php echo $this->get_label('supported zip codes'); ?></td>
    <td><textarea name="local_pickup_zipcodes" id="local_pickup_zipcodes" cols="31" rows="5"><?php echo $this->get_variable('local_pickup_zipcodes');?></textarea><span class="mandatory">*</span><br />
    <span style="color: #888888;"><?php echo $this->get_label('zip example'); ?></span></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr><td colspan="4" height="10px"></td></tr>
  
  <tr>
    <td>&nbsp;</td>
    <td ><?php echo $this->get_label('shipping type'); ?></td>
    <td><select name="local_shipping_type" id="local_shipping_type">
    <option value="1" <?php if( $this->get_variable('local_shipping_type')=="1"){?>selected="selected" <?php }?> ><?php echo $this->get_label('free shipping'); ?></option>
    <option value="2" <?php if( $this->get_variable('local_shipping_type')=="2"){?>selected="selected" <?php }?> ><?php echo $this->get_label('flat rate for any quantity1'); ?></option>
    <option value="3" <?php if( $this->get_variable('local_shipping_type')=="3"){?>selected="selected" <?php }?> ><?php echo $this->get_label('fixed rate per unit1'); ?></option>
    </select><span class="mandatory" style="padding-top: 40px;">*</span></td>
    <td>&nbsp;</td>
  </tr>
  
   <tr id="local_price_tr">
    <td ></td>
    <td width="180px">&nbsp;</td>
    <td style="padding-top: 10px;"><input name="local_price" type="text" id="local_price" class="textStylePadding" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="<?php  if($this->get_variable('local_price')>0)echo $this->get_variable('local_price');?>"><span class="mandatory">*</span><br />
       <span style="color: #888888;"><?php echo $this->get_label('flat rate for any quantity');?></span></td>
    <td>&nbsp;</td>
  </tr>
  
  
   <tr id="local_price_per_additional_unit_tr">
    <td ></td>
    <td width="180px">&nbsp;</td>
    <td style="padding-top: 10px;"><input name="local_price_per_additional_unit" type="text" id="local_price_per_additional_unit" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" class="textStylePadding" value="<?php  if($this->get_variable('local_price_per_additional_unit')>0)echo $this->get_variable('local_price_per_additional_unit');?>"><br />
       <span style="color: #888888;"><?php echo $this->get_label('shipping price per additional unit'); ?></span></td>
    <td>&nbsp;</td>
  </tr>
  
  
  
   <tr id="local_free_units_tr">
    <td ></td>
    <td width="180px">&nbsp;</td>
    <td style="padding-top: 10px;"><input name="local_free_units" type="text" id="local_free_units" onkeyup="this.value = this.value.replace(/[^0-9]/g,'');" class="textStylePadding" value="<?php  if($this->get_variable('local_free_units')>0)echo $this->get_variable('local_free_units');?>"><br />
       <span style="color: #888888;"><?php echo $this->get_label('free shipping above X units'); ?></span></td>
    <td>&nbsp;</td>
  </tr>
  
    <tr><td colspan="4" height="10px"></td></tr>
    
    
    <tr>
    <td ></td>
    <td width="180px"><?php echo $this->get_label('local pickup'); ?></td>
    <td><input name="local_pickup" type="checkbox" id="local_pickup" class="textStylePadding" <?php if($this->get_variable('local_pickup')=="1"){?> checked="checked" <?php }?> ></td>
    <td>&nbsp;</td>
  </tr>
  
    
  
  <tr><td colspan="4" height="10px"></td></tr>
<tr><td colspan="4" class="heading_td"><strong><?php echo $this->get_label('national settings');?></strong></td></tr>
<tr><td colspan="4" height="5px"></td></tr>
  
  
   <tr><td colspan="4" height="10px"></td></tr>
  
  <tr>
    <td>&nbsp;</td>
    <td ><?php echo $this->get_label('shipping type'); ?></td>
    <td><select name="nat_shipping_type" id="nat_shipping_type">
    <option value="0" <?php if( $this->get_variable('nat_shipping_type')=="0"){?>selected="selected" <?php }?>><?php echo $this->get_label('no shipping'); ?></option>
    <option value="1" <?php if( $this->get_variable('nat_shipping_type')=="1"){?>selected="selected" <?php }?>><?php echo $this->get_label('free shipping'); ?></option>
    <option value="2" <?php if( $this->get_variable('nat_shipping_type')=="2"){?>selected="selected" <?php }?>><?php echo $this->get_label('flat rate for any quantity1'); ?></option>
    <option value="3" <?php if( $this->get_variable('nat_shipping_type')=="3"){?>selected="selected" <?php }?>><?php echo $this->get_label('fixed rate per unit1'); ?></option>
    </select><span class="mandatory" style="padding-top: 40px;">*</span></td>
    <td>&nbsp;</td>
  </tr>
  
     <tr id="nat_price_tr">
    <td ></td>
    <td width="180px">&nbsp;</td>
    <td style="padding-top: 10px;"><input name="nat_price" type="text" id="nat_price" class="textStylePadding" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="<?php  if($this->get_variable('nat_price')>0)echo $this->get_variable('nat_price');?>"><span class="mandatory">*</span><br />
       <span style="color: #888888;"><?php echo $this->get_label('flat rate for any quantity');?></span></td>
    <td>&nbsp;</td>
  </tr>
  
  
   <tr id="nat_price_per_additional_unit_tr">
    <td ></td>
    <td width="180px">&nbsp;</td>
    <td style="padding-top: 10px;"><input name="nat_price_per_additional_unit" type="text" id="nat_price_per_additional_unit" class="textStylePadding" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="<?php  if($this->get_variable('nat_price_per_additional_unit')>0)echo $this->get_variable('nat_price_per_additional_unit');?>"><br />
       <span style="color: #888888;"><?php echo $this->get_label('shipping price per additional unit'); ?></span></td>
    <td>&nbsp;</td>
  </tr>
  
  
  
   <tr id="nat_free_units_tr">
    <td ></td>
    <td width="180px">&nbsp;</td>
    <td style="padding-top: 10px;"><input name="nat_free_units" type="text" id="nat_free_units" class="textStylePadding" onkeyup="this.value = this.value.replace(/[^0-9]/g,'');" value="<?php  if($this->get_variable('nat_free_units')>0)echo $this->get_variable('nat_free_units');?>"><br />
       <span style="color: #888888;"><?php echo $this->get_label('free shipping above X units'); ?></span></td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr><td colspan="4" height="15px"></td></tr> 
  
 <tr><td colspan="4" height="5px"></td></tr> 
<tr><td colspan="4" class="heading_td"><strong><?php echo $this->get_label('international settings');?></strong></td></tr>
<tr><td colspan="4" height="5px"></td></tr>
  
   <tr><td colspan="4" height="10px"></td></tr>
  
  <tr>
    <td>&nbsp;</td>
    <td ><?php echo $this->get_label('shipping type'); ?></td>
    <td><select name="inat_shipping_type" id="inat_shipping_type">
    <option value="0" <?php if( $this->get_variable('inat_shipping_type')=="0"){?>selected="selected" <?php }?>><?php echo $this->get_label('no shipping'); ?></option>
    <option value="1" <?php if( $this->get_variable('inat_shipping_type')=="1"){?>selected="selected" <?php }?>><?php echo $this->get_label('free shipping'); ?></option>
    <option value="2" <?php if( $this->get_variable('inat_shipping_type')=="2"){?>selected="selected" <?php }?>><?php echo $this->get_label('flat rate for any quantity1'); ?></option>
    <option value="3" <?php if( $this->get_variable('inat_shipping_type')=="3"){?>selected="selected" <?php }?>><?php echo $this->get_label('fixed rate per unit1'); ?></option>
    </select><span class="mandatory" style="padding-top: 40px;">*</span></td>
    <td>&nbsp;</td>
  </tr>
  
     <tr id="inat_price_tr">
    <td ></td>
    <td width="180px">&nbsp;</td>
    <td style="padding-top: 10px;"><input name="inat_price" type="text" id="inat_price" class="textStylePadding" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="<?php  if($this->get_variable('inat_price')>0)echo $this->get_variable('inat_price');?>"><span class="mandatory">*</span><br />
       <span style="color: #888888;"><?php echo $this->get_label('flat rate for any quantity');?></span></td>
    <td>&nbsp;</td>
  </tr>
  
  
   <tr id="inat_price_per_additional_unit_tr">
    <td ></td>
    <td width="180px">&nbsp;</td>
    <td style="padding-top: 10px;"><input name="inat_price_per_additional_unit" type="text" id="inat_price_per_additional_unit" class="textStylePadding" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="<?php  if($this->get_variable('inat_price_per_additional_unit')>0)echo $this->get_variable('inat_price_per_additional_unit');?>"><br />
       <span style="color: #888888;"><?php echo $this->get_label('shipping price per additional unit'); ?></span></td>
    <td>&nbsp;</td>
  </tr>
  
  
  
   <tr id="inat_free_units_tr">
    <td ></td>
    <td width="180px">&nbsp;</td>
    <td style="padding-top: 10px;"><input name="inat_free_units" type="text" id="inat_free_units" class="textStylePadding" onkeyup="this.value = this.value.replace(/[^0-9]/g,'');" value="<?php  if($this->get_variable('inat_free_units')>0)echo $this->get_variable('inat_free_units');?>"><br />
       <span style="color: #888888;"><?php echo $this->get_label('free shipping above X units'); ?></span></td>
    <td>&nbsp;</td>
  </tr>
  

  
  
  <tr><td colspan="4" height="30px"></td></tr>
  
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td><input type="submit" name="Submit" value="<?php echo $this->get_label('submit'); ?>" class="btn btn-default"></td>
    <td>&nbsp;</td>
  </tr>
</table>

<script type="text/javascript">
$(document).ready(function(){
	
	     if($("#local_shipping_type").val()==1)
	     $("#local_price_tr").hide();
			
		 if($("#local_shipping_type").val()==1 || $("#local_shipping_type").val()==2)
		 {
			$("#local_price_per_additional_unit_tr").hide();
			$("#local_free_units_tr").hide();
		 }

		 if($("#nat_shipping_type").val()==0 || $("#nat_shipping_type").val()==1)
	 	 $("#nat_price_tr").hide();
			
		 if($("#nat_shipping_type").val()==0 || $("#nat_shipping_type").val()==1 || $("#nat_shipping_type").val()==2)
		 {
			$("#nat_price_per_additional_unit_tr").hide();
			$("#nat_free_units_tr").hide();
		 }
		
		 if($("#inat_shipping_type").val()==0 || $("#inat_shipping_type").val()==1)
		 $("#inat_price_tr").hide();
		
			
		 if($("#inat_shipping_type").val()==0 || $("#inat_shipping_type").val()==1 || $("#inat_shipping_type").val()==2)
		 {
			$("#inat_price_per_additional_unit_tr").hide();
			$("#inat_free_units_tr").hide();
		 }
	

		 if($("#local_shipping_type").val()==2)
		 $("#local_price_label").html("<?php echo $this->get_label('flat rate for any quantity');?>");
		 else if($("#local_shipping_type").val()==3) 
		 $("#local_price_label").html("<?php echo $this->get_label('shipping price per unit');?>");
				

		 if($("#nat_shipping_type").val()==2)
		 $("#nat_price_label").html("<?php echo $this->get_label('flat rate for any quantity');?>");
		 else if($("#nat_shipping_type").val()==3)
		 $("#nat_price_label").html("<?php echo $this->get_label('shipping price per unit');?>");

				
		 if($("#inat_shipping_type").val()==2)
		 $("#inat_price_label").html("<?php echo $this->get_label('flat rate for any quantity');?>");
		 else if($("#inat_shipping_type").val()==3)
		 $("#inat_price_label").html("<?php echo $this->get_label('shipping price per unit');?>");
				









	
	
	$("#local_shipping_type").change(function(){

		$("#local_price_tr").hide();
		$("#local_price_per_additional_unit_tr").hide();
		$("#local_free_units_tr").hide();
		
		if($("#local_shipping_type").val()=="2")
			{
			
				$("#local_price_tr").show();
				$("#local_price_label").html("<?php echo $this->get_label('flat rate for any quantity');?>");
			
			}
		else if($("#local_shipping_type").val()=="3")
			{
			
				$("#local_price_tr").show();
				$("#local_price_label").html("<?php echo $this->get_label('shipping price per unit');?>");
				$("#local_price_per_additional_unit_tr").show();
				$("#local_free_units_tr").show();
				
			}

	});
	


	$("#nat_shipping_type").change(function(){

		$("#nat_price_tr").hide();
		$("#nat_price_per_additional_unit_tr").hide();
		$("#nat_free_units_tr").hide();
		
		 if($("#nat_shipping_type").val()=="2")
			{
				$("#nat_price_tr").show();
				$("#nat_price_label").html("<?php echo $this->get_label('flat rate for any quantity');?>");
			
			}
		else if($("#nat_shipping_type").val()=="3")
			{
				$("#nat_price_tr").show();
				$("#nat_price_label").html("<?php echo $this->get_label('shipping price per unit');?>");
				$("#nat_price_per_additional_unit_tr").show();
				$("#nat_free_units_tr").show();
				
			}

	});

	$("#inat_shipping_type").change(function(){

		$("#inat_price_tr").hide();
		$("#inat_price_per_additional_unit_tr").hide();
		$("#inat_free_units_tr").hide();
		
		if($("#inat_shipping_type").val()=="2")
			{
			
				$("#inat_price_tr").show();
				$("#inat_price_label").html("<?php echo $this->get_label('flat rate for any quantity');?>");
			
			}
		else if($("#inat_shipping_type").val()=="3")
			{
			
				$("#inat_price_tr").show();
				$("#inat_price_label").html("<?php echo $this->get_label('shipping price per unit');?>");
				$("#inat_price_per_additional_unit_tr").show();
				$("#inat_free_units_tr").show();
				
			}

	});
	

});
</script>
<?php $form->end(); ?>
<?php $this->dispatch("layout/footer");?>