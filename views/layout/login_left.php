<?php $wishlist_cnt=$this->get_variable('wishlist_cnt');?>
<div class="filterLeft contentLeft registered" style="margin:10px 10px 30px 0px;">
<div class="filterTitle" style="margin-bottom:10px;"><?php echo $this->get_label('orders');?></div>
    <a href="<?php echo $this->make_url("user/home");?>" <?php if($this->get_variable('order_tab')!=""){ echo 'class="'.$this->get_variable('order_tab').'"';}else{ ?> class="filterContent"<?php } ?> ><?php echo $this->get_label('my orders').' '.$this->get_order_count();?></a>
    <a href="<?php echo $this->make_url("user/wishlist");?>" <?php if($this->get_variable('wishlist_tab')!=""){ echo 'class="'.$this->get_variable('wishlist_tab').'"';}else{ ?> class="filterContent"<?php } ?>><?php echo $this->get_label('wishlist').' '.$this->get_wishlist_cnt();?></a>
    <a href="<?php echo $this->make_url("user/payments");?>" <?php if($this->get_variable('payments_tab')!=""){ echo 'class="'.$this->get_variable('payments_tab').'"';}else{ ?> class="filterContent"<?php } ?>><?php echo $this->get_label('payment details');?></a>
<div class="filterTitle" style="margin-top:15px;margin-bottom:10px;"><?php echo $this->get_label('settings');?></div>
    <a href="<?php echo $this->make_url("user/edit_profile");?>" <?php if($this->get_variable('profile_tab')!=""){ echo 'class="'.$this->get_variable('profile_tab').'"';}else{ ?> class="filterContent"<?php } ?> ><?php echo $this->get_label('personal information');?></a>
    <a href="<?php echo $this->make_url("user/change_password");?>" <?php if($this->get_variable('chpassword_tab')!=""){ echo 'class="'.$this->get_variable('chpassword_tab').'"';}else{ ?> class="filterContent"<?php } ?> ><?php echo $this->get_label('change pwd');?></a>
    <a href="<?php echo $this->make_url("user/manage_address");?>" <?php if($this->get_variable('mnaddress_tab')!=""){ echo 'class="'.$this->get_variable('mnaddress_tab').'"';}else{ ?> class="filterContent"<?php } ?>><?php echo $this->get_label('manageaddress');?></a>
</div>    