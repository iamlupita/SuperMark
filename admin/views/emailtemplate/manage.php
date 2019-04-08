<?php 
$this->dispatch("layout/header/3/_33");
$res=$this->get_result('res');
?>


<div class="sub_menu"><?php echo $this->get_label('email templates');?></div>

  
<div class="sub_menu"><?php echo $this->get_label('email to users');?></div>


  
<table style="width: 100%" cellpadding="0" cellspacing="0">
<tr>
<td></td>
<td width="300px"><?php echo $this->get_label('welcome to account',array('x'=>Settings::get_instance()->read('engine_name'))); ?></td>
<td width="500px"><a href="<?php echo $this->make_url("emailtemplate/edit/1"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>

<tr><td colspan="4" height="10px"></td></tr>


<tr>
<td>
</td>
<td><?php echo $this->get_label('email confirmation'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/2"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>

<tr><td colspan="4" height="10px"></td></tr>


<tr>
<td>
</td>
<td><?php echo $this->get_label('password recovery'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/3"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>

<tr><td colspan="4" height="10px"></td></tr>



<tr>
<td></td>
<td><?php echo $this->get_label('account status updated'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/4"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>

<tr><td colspan="4" height="10px"></td></tr>


<tr>
<td></td>
<td><?php echo $this->get_label('order created'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/5"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>

<tr><td colspan="4" height="10px"></td></tr>

<tr>
<td></td>
<td><?php echo $this->get_label('order payment processed'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/6"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>

<tr><td colspan="4" height="10px"></td></tr>

<tr>
<td></td>
<td><?php echo $this->get_label('payment failed'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/7"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>


<tr><td colspan="4" height="10px"></td></tr>

<tr>
<td></td>
<td><?php echo $this->get_label('order item shipped'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/8"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>


<tr><td colspan="4" height="10px"></td></tr>

<tr>
<td></td>
<td><?php echo $this->get_label('order item delivered'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/9"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>


<tr><td colspan="4" height="10px"></td></tr>

<tr>
<td></td>
<td><?php echo $this->get_label('return request approved'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/10"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>


<tr><td colspan="4" height="10px"></td></tr>

<tr>
<td></td>
<td><?php echo $this->get_label('return request rejected'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/11"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>


<tr><td colspan="4" height="20px"></td></tr>


</table>

<div class="sub_menu"><?php echo $this->get_label('email to admin');?></div>


  
<table style="width: 100%" cellpadding="0" cellspacing="0">
<tr>
<td></td>
<td width="300px"><?php echo $this->get_label('order created'); ?></td>
<td width="500px"><a href="<?php echo $this->make_url("emailtemplate/edit/12"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>

<tr><td colspan="4" height="10px"></td></tr>


<tr>
<td>
</td>
<td><?php echo $this->get_label('order payment processed'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/13"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>

<tr><td colspan="4" height="10px"></td></tr>

<tr>
<td></td>
<td><?php echo $this->get_label('payment failed'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/14"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>


<tr><td colspan="4" height="10px"></td></tr>



<tr>
<td>
</td>
<td><?php echo $this->get_label('return request created'); ?></td>
<td><a href="<?php echo $this->make_url("emailtemplate/edit/15"); ?>"><?php echo $this->get_label("edit");?></a></td>
<td></td>
</tr>

<tr><td colspan="4" height="10px"></td></tr>


</table>



<?php $this->dispatch("layout/footer");?>