<?php
include_once COMMON_DIR_PATH.'helpers'.DS."login-helper.php";
include_once COMMON_DIR_PATH.'helpers'.DS."utility-helper.php";

class CartController extends AppController
{
	function before_execute()
	{
		if($this->get_action()=="checkout" || $this->get_action()=="order_details" || $this->get_action()=="change_reorder_quantity" || $this->get_action()=="add_address" || $this->get_action()=="change_checkout_quantity") 
		{
			if(LoginHelper::validate_user_login()==0)
			$this->flash($this->get_message('login to continue'), $this->make_url('user/login'),0);
				
			if($this->get_action()=="checkout" && !isset($_COOKIE[COOKIE_CART_ITEMS]) && !isset($_COOKIE[COOKIE_REORDER_ITEMS]))
			$this->flash('', $this->make_url('index/index'));
		}
	}
	
	function add_address_action()
	{
		$this->disable_notice_area();
		$user_id=$this->read_cookie_param(COOKIE_LOGINID);
		$contact_name=$this->read_post_param('name');
		$contact_address1=$this->read_post_param('address1');
		$contact_address2=$this->read_post_param('address2');
		$contact_phoneno=$this->read_post_param('phno');
		$contact_country=$this->read_post_param('country');
		$contact_state=$this->read_post_param('state');
		$contact_city=$this->read_post_param('city');
		$contact_zipcode=$this->read_post_param('zipcode');
		$existingid=$this->read_post_param('existingid');
	
		$db= DBLayer::get_instance();
		$t=time();
		
		
		if($contact_name=="" || $contact_address1=="" || $contact_phoneno=="" || $contact_country=="" || $contact_city=="" || $contact_state=="" || $contact_zipcode=="")
		{
			echo 'error';
			exit;
		}
		else 
		{
			if($existingid =="")
			{
				$sql="INSERT INTO ".TABLE_PREFIX."user_address (`user_id`,`name`,`address1`,`address2`,phoneno,city,country,state,zipcode) values (?,?,?,?,?,?,?,?,?)";
				$res=$db->execute_query($sql,array($user_id,$contact_name,$contact_address1,$contact_address2,$contact_phoneno,$contact_city,$contact_country,$contact_state,$contact_zipcode));
				$existingid=$res->get_last_id();
			}
			else
			{
				$sql="UPDATE ".TABLE_PREFIX."user_address set name=?,address1=?,address2=?,phoneno=?,city=?,country=?,state=?,zipcode=? where id=? and user_id=?";
				$res=$db->execute_query($sql,array($contact_name,$contact_address1,$contact_address2,$contact_phoneno,$contact_city,$contact_country,$contact_state,$contact_zipcode,$existingid,$user_id));
			}
			echo $existingid; 
			exit;
		}
	}
	
	
	
	function update_action()
	{
		$this->disable_notice_area();
		
		$db=DBLayer::get_instance();
		
		$cart_items=$_COOKIE[COOKIE_CART_ITEMS];
		$cartcound=0;
		$pro_id='';
		$cartstring='';
		
		if($cart_items !="")
		{
			$cart_items1=explode(",", $cart_items);
			$arraycount=count($cart_items1);
			
			for($i=0;$i < $arraycount;$i++)
			{
				if(isset($cart_items1[$i]) && $cart_items1[$i] !="")
				{
					$cart_items2=explode("-",$cart_items1[$i]);
					if(intval($cart_items2[0]) >0)
					{
						$stock=$this->get_stock($cart_items2[0]);
						
						if($this->get_item_exists($cart_items2[0],1) && $stock >0)
						{
							$orderedstock=$cart_items2[1];
							if($orderedstock > $stock)
							$orderedstock=$stock;
								
							if($cartstring !='')
							$cartstring.=',';
							
							$cartstring.=$cart_items2[0].'-'.$orderedstock;
							
							if($pro_id !='')
							$pro_id.=',';
							
							$pro_id.=$cart_items2[0];
							
							$cartcound=$cartcound+$orderedstock;
						}
					}
				}
			}
			
			setcookie(COOKIE_CART_ITEMS,$cartstring,0,$this->get_base_path(),$this->get_base_domain());

			if($pro_id !="")
			{
				$res1=$db->execute_query("select id,prod_stock,sale_price,special_offer_price,status from ".TABLE_PREFIX."product where id IN(".$pro_id.")");
				$this->set_result("cartitem",$res1);
			}
		}	
		$this->set_variable("cartcound",$cartcound);
	}
	
	function change_checkout_quantity_action()
	{
		$db=DBLayer::get_instance();
		$pid=$this->read_page_param(1);
		$quantity=intval($this->read_page_param(2));
		$page_type=intval($this->read_page_param(3)); // 1 From Reorder
		
		$itemstock=$this->get_stock($pid);
		
		if($quantity <=0)
		{
			echo "quantity";
			die;
		}
		
		if($itemstock < $quantity)
		{
			echo "stock";
			die;
		}
		
		$cart_items='';
		if($page_type ==0)
		{
			if(isset($_COOKIE[COOKIE_CART_ITEMS]))
			$cart_items=$this->read_cookie_param(COOKIE_CART_ITEMS);
		}
		else if($page_type ==1)
		{
			if(isset($_COOKIE[COOKIE_REORDER_ITEMS]))
			$cart_items=$this->read_cookie_param(COOKIE_REORDER_ITEMS);
		}
		
		$new_str="";
		$cartcound=0;
		if(isset($cart_items) && $cart_items !="")
		{
			$cart_items=explode(",",$cart_items);
		
			for($i=0;$i < count($cart_items);$i++)
			{
				$items=explode("-",$cart_items[$i]);
		
				if(intval($items[0]) >0)
				{
					$stock=$this->get_stock($items[0]);
				
					if($this->get_item_exists($items[0],1) && $stock >0)
					{
						if($items[0]==$pid)
						$orderedstock=$quantity;
						else
						$orderedstock=$items[1];
						
						if($orderedstock > $stock)
						$orderedstock=$stock;
				
						if($new_str !='')
						$new_str.=',';
				
						$new_str.=$items[0].'-'.$orderedstock;
				
				
						$cartcound=$cartcound+$orderedstock;
					}
				}
			}
			
			if($page_type ==0)
			setcookie(COOKIE_CART_ITEMS,$new_str,0,$this->get_base_path(),$this->get_base_domain());
			else if($page_type ==1)
			setcookie(COOKIE_REORDER_ITEMS,$new_str,0,$this->get_base_path(),$this->get_base_domain());
				
		}
		
		
		if($page_type ==0)
		echo $cartcound;
		else if($page_type ==1)
		echo 0;
		
		die;
		
	}
	function change_quantity_action()
	{
		$db=DBLayer::get_instance();
		$pro_id=$this->read_page_param(1);
		$quantity=intval($this->read_page_param(2));
		
		$stock=$this->get_stock($pro_id);
		
		if($quantity <=0)
		{
			echo "quantity";
			die;
		}
		
		if($stock < $quantity)
		{
			echo "stock";
			die;
		}
		
		$cart_items=$this->read_cookie_param(COOKIE_CART_ITEMS);
		$new_str="";
		if(isset($cart_items) && $cart_items !="")
		{
			$cart_items=explode(",",$cart_items);
			
			for($i=0;$i < count($cart_items);$i++)
			{
				$items=explode("-",$cart_items[$i]);
				
				
				if($new_str !='')
				$new_str.=',';
				
				if($items[0]==$pro_id)
				$new_str.=$items[0]."-".$quantity;
				else
				$new_str.=$items[0]."-".$items[1];

			}
			setcookie(COOKIE_CART_ITEMS,$new_str,0,$this->get_base_path(),$this->get_base_domain());
		}
		
		$total=$this->get_product_pricing($pro_id,$quantity);
		$total=$this->get_money_format($total);
		
		$grandcost=$this->get_grand_total($new_str,1);
		$grandcost=$this->get_money_format($grandcost);
		$str=$total.'@#'.$grandcost;
	
		echo $str;
		die;
	}
	
	function change_reorder_quantity_action()
	{
		$db=DBLayer::get_instance();
		$pro_id=$this->read_page_param(1);
		$quantity=intval($this->read_page_param(2));
		$grcost=$this->read_page_param(3);
		$old_qty=$this->read_page_param(4);
		
	
		$stock=$this->get_stock($pro_id);
		
		if($quantity <=0)
		{
			echo "quantity";
			die;
		}
	
		if($stock < $quantity)
		{
			echo "stock";
			die;
		}
		$prod_price=$this->get_product_pricing($pro_id);
		$grcost=$grcost-($prod_price*$old_qty);
		
		$total=$prod_price*$quantity;
		$total_format=$this->get_money_format($total);
		
		$grandcost=$grcost+$total;
		$grandcost_format=$this->get_money_format($grandcost);
		
		$str=$total_format.'@#@'.$grandcost_format.'@#@'.$grandcost.'@#@'.$prod_price;
		
		echo $str;
		die;
	}
	
	function checkout_action()
	{
	
		
		$c1="";
		$c2="";
		if(isset($_COOKIE[COOKIE_REORDER_ITEMS]))
		$c1=$_COOKIE[COOKIE_REORDER_ITEMS];
		
		if(isset($_COOKIE[COOKIE_CART_ITEMS]))
		$c2=$_COOKIE[COOKIE_CART_ITEMS];
		
		
		
		if($c1=="" && $c2=="")
		{
			header("Location: ".$this->make_url("index/index"));
			die;
		}
		
		$user=$this->read_cookie_param(COOKIE_LOGINID);
		$this->set_variable("userid",$user);
		
		$type=0;
		$type=intval($this->read_page_param(1));//1 from reorder page
		$this->set_variable("page_type",$type);
		
			
	
		$db= DBLayer::get_instance();
		
		$res=$db->execute_query("select * from ".TABLE_PREFIX."user_address where user_id=? order by id desc",array($user));
		$this->set_result("user_address",$res);
		
		$res=$db->execute_query("select * from ".TABLE_PREFIX."countries ORDER BY cname");
		$this->set_result("countries",$res);
	
		$payment_go=0;

		$this->set_variable("grandcost", '');
		$this->set_variable("user_id", '');
		$this->set_variable("order_id", '');
		$this->set_variable("payment_go", 0);
		
		if($_POST)
		{
			$billing_address_id=$this->read_post_param('billaddressid1');
			$shipping_address_id=$this->read_post_param('shipaddressid1');
			$type=intval($this->read_post_param('page_type'));
			
			$count=$db->read_single_column("select count(id) from ".TABLE_PREFIX."user_address where id=? and user_id=?",array($billing_address_id,$user));
			$count1=$db->read_single_column("select count(id) from ".TABLE_PREFIX."user_address where id=? and user_id=?",array($shipping_address_id,$user));
			
			if($count==0 || $count1==0)
			{
				$this->set_notice($this->get_message('please check your address details'));
			}
			else
			{
			$grand_total_cost=0;
			$total_shipping_cost=0;
			$sub_total_cost=0;
			
			$res=$db->execute_query("select * from ".TABLE_PREFIX."user_address where id=?",array($shipping_address_id));
			$row=$res->fetch_assoc();
			
			$country=$row['country'];
			$zipcode=$row['zipcode'];
			
			if($type==1)
			$items=$_COOKIE[COOKIE_REORDER_ITEMS];
			else 
			$items=$_COOKIE[COOKIE_CART_ITEMS];
			
			$cart_items = explode(",", $items);
			$cartcount=count($cart_items);
			$k=0;
			
			$order_id=0;
			for($i=0;$i < $cartcount;$i++)
			{
					$cart_item = explode("-", $cart_items[$i]);
			
					//if(!$this->get_product_stock_available($cart_item[0]))
					//continue;
					$k++;
					
					$res1=$db->execute_query("select shipping_class from ".TABLE_PREFIX."product where id=?",array($cart_item[0]));
					$row1=$res1->fetch_assoc();
			
					$prod_id=$cart_item[0];
					$prod_name=$this->get_product_name($prod_id);
					$prod_image=$this->get_product_image($prod_id);
					$prod_quantity=$cart_item[1];
					$prod_price=$this->get_product_pricing($prod_id);
					$shipping_class=$row1['shipping_class'];
			
					$res2=$db->execute_query("select * from ".TABLE_PREFIX."shipping_classes where id=?",array($shipping_class));
					$row2=$res2->fetch_assoc();
			
					$base_country=Settings::get_instance()->read('country');
			
					if($country!=$base_country)
					{
						$shipping_type=$row2['inat_shipping_type'];
		
						if($shipping_type==0 || $shipping_type==1)
						$shipping_cost=0;
						else if($shipping_type==2)
						$shipping_cost=$row2['inat_price'];
						else if($shipping_type==3 && $cart_item[1]>$row2['inat_free_units'] && $row2['inat_free_units']>0 )
						{
								$shipping_cost=0;
								$shipping_type=1;
						}
						else
							$shipping_cost=$row2['inat_price']+(($cart_item[1]-1)*$row2['inat_price_per_additional_unit']);
					
					}
					else
					{
						$local=0;
						$supported_zipcodes=explode(",", $row2['local_pickup_zipcodes']);
						
						for($j=0;$j<count($supported_zipcodes);$j++)
						{
							if(strpos($supported_zipcodes[$j],':')>0)
							{
								
								
								if($supported_zipcodes[$j][0]=='/' && $supported_zipcodes[$j][strlen($supported_zipcodes[$j])-1]=='/')
								{
									$return=preg_match_all($supported_zipcodes[$j].'i',$zipcode,$matches);
									if($return >0)
									{
										$local=1;
										break;
									}
									else
										continue;
								}
								
								
								$supported_zipcode = explode(":", $supported_zipcodes[$j]);
						
								if($zipcode>=$supported_zipcode[0] && $zipcode<=$supported_zipcode[1])
								{
									$local=1;
									break;
								}
							}
							elseif($supported_zipcodes[$j]==$zipcode)
							{
								$local=1;
								break;
							}
						}
			
					if($local==1)
					{
						$shipping_type=$row2['local_shipping_type'];
				
						if($shipping_type==1)
						$shipping_cost=0;
						else if($shipping_type==2)
						$shipping_cost=$row2['local_price'];
						else if($shipping_type==3 && $cart_item[1]>$row2['local_free_units'] && $row2['local_free_units']>0)
						{
								$shipping_cost=0;
								$shipping_type=1;
						}
						else
							$shipping_cost=$row2['local_price']+(($cart_item[1]-1)*$row2['local_price_per_additional_unit']);
					}
					else
					{
						$shipping_type=$row2['nat_shipping_type'];
						
						if($shipping_type==0)
						$shipping_cost=0;
						else if($shipping_type==1)
						$shipping_cost=0;
						else if($shipping_type==2)
						$shipping_cost=$row2['nat_price'];
						else if($shipping_type==3 && $cart_item[1]>$row2['nat_free_units'] && $row2['nat_free_units']>0)
						{
							$shipping_cost=0;
							$shipping_type=1;
						}
						else
							$shipping_cost=$row2['nat_price']+(($cart_item[1]-1)*$row2['nat_price_per_additional_unit']);
					}
				}
			
				
				if(isset($_POST["local_pickup_checkbox_$prod_id"]))
				$localpickup_checked=1;
				else
				$localpickup_checked=0;
				
				if($localpickup_checked ==1)
				$shipping_cost=0;
				
				
				
				$total_shipping_cost=$total_shipping_cost+$shipping_cost;
				$sub_total_cost=($prod_quantity*$prod_price)+$shipping_cost;
				$grand_total_cost=$grand_total_cost+$sub_total_cost;
				
				
				if($k==1)
				{
					$t=time();
					$res3=$db->execute_query("INSERT INTO ".TABLE_PREFIX."order (`user_id`,`order_date`,`payment_method`,`grand_cost`,payment_date,billing_address_id,shipping_address_id,status) values (?,?,?,?,?,?,?,?)",array($user,$t,'0','0','',$billing_address_id,$shipping_address_id,1));
					$order_id=$res3->get_last_id();
				}
				
				$res4=$db->execute_query("INSERT INTO ".TABLE_PREFIX."order_items (`order_id`,`pro_id`,`unit_price`,`shipping_cost`,`quantity`,`total_cost`,`local_pickup`) values (?,?,?,?,?,?,?)",array($order_id,$prod_id,$prod_price,$shipping_cost,$prod_quantity,$sub_total_cost,$localpickup_checked));
				
		}
		
		
			if($order_id >0)
			{
				
				$uname=$this->get_user_name($user);
				$email=$this->get_user_email($user);
				
				$order_url=$this->make_url('order/details/'.$order_id);
				
				$res1=$db->execute_query("select sub,body from ".TABLE_PREFIX."emailtemplates where id=5");//to user.. Order Created
				$result1=$res1->fetch_assoc();
				$subject=$result1['sub'];
				$message=$result1['body'];
				
				$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
				$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
				
				$message=str_replace("{NAME}",$uname,$message);
				$message=str_replace("{ORDERURL}",$order_url,$message);
				
				UtilityHelper::send_mail($email,$subject,nl2br($message));
				
				$admin_email=Settings::get_instance()->read('general_notification_email');
				$order_url=$this->make_base_url('sales/details/'.$order_id,ADMIN_DIR);
				
				$res1=$db->execute_query("select sub,body from ".TABLE_PREFIX."emailtemplates where id=12");//to admin.. Order Created
				$result1=$res1->fetch_assoc();
				$subject=$result1['sub'];
				$message=$result1['body'];
					
				$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
				$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
				
				$message=str_replace("{ORDERURL}",$order_url,$message);
				
				UtilityHelper::send_mail($admin_email,$subject,nl2br($message));
				
				
				$this->set_variable("grandcost", $grand_total_cost);
				$this->set_variable("user_id", $user);
				$this->set_variable("order_id", $order_id);
				$this->set_variable("payment_go", 1);
				
				$res3=$db->execute_query("update ".TABLE_PREFIX."order set grand_cost=? where id=? and user_id=?",array($grand_total_cost,$order_id,$user));
			}
			
			
			if($type==1)
			setcookie(COOKIE_REORDER_ITEMS,"",0,$this->get_base_path(),$this->get_base_domain());
			else
			setcookie(COOKIE_CART_ITEMS,"",0,$this->get_base_path(),$this->get_base_domain());
			
		}
		
		}
		
	}
	
	function order_details_action()
	{
		$this->disable_notice_area();
		
		$address_id=$this->read_post_param('id');
		$page_type=intval($this->read_post_param('page_type'));//1 from reorder
		
		$this->set_variable('page_type',$page_type);
		
		$db= DBLayer::get_instance();
		
		
		$order_details = array();
		$grand_total_cost=0;
		$total_item_cost=0;
		$total_shipping_cost=0;
		$localpickup=0;
		$sub_total_cost=0;
		
		$res=$db->execute_query("select * from ".TABLE_PREFIX."user_address where id=?",array($address_id));
		$row=$res->fetch_assoc();
		
		$country=$row['country'];
		$zipcode=$row['zipcode'];
		
		$cokkie_items='';
		if($page_type==1)
		{
			if(isset($_COOKIE[COOKIE_REORDER_ITEMS]))
			$cokkie_items=$_COOKIE[COOKIE_REORDER_ITEMS];
		}
		else
		{
			if(isset($_COOKIE[COOKIE_CART_ITEMS]))
			$cokkie_items=$_COOKIE[COOKIE_CART_ITEMS];
		}
		
		
		$new_str='';
		if(isset($cokkie_items) && $cokkie_items !="")
		{
			$cokkie_items=explode(",",$cokkie_items);
		
			for($i=0;$i < count($cokkie_items);$i++)
			{
				$items=explode("-",$cokkie_items[$i]);
		
				if(intval($items[0]) >0)
				{
					$stock=$this->get_stock($items[0]);
					if($this->get_item_exists($items[0],1) && $stock >0)
					{
						$orderedstock=$items[1];
		
						if($orderedstock > $stock)
						$orderedstock=$stock;
		
						if($new_str !='')
						$new_str.=',';
		
						$new_str.=$items[0].'-'.$orderedstock;
					}
				}
			}
			if($page_type ==0)
			setcookie(COOKIE_CART_ITEMS,$new_str,0,$this->get_base_path(),$this->get_base_domain());
			else if($page_type ==1)
			setcookie(COOKIE_REORDER_ITEMS,$new_str,0,$this->get_base_path(),$this->get_base_domain());
		}
		
		
		$cokkie_items=$new_str;
		
		if(isset($cokkie_items) && $cokkie_items !='')
		$items=$cokkie_items;
		else
		{
			echo "empty";
			die;
		}
		
		
		
		
		$cart_items = explode(",", $items);
		$JSStr='';
		$k=0;
		for($i=0;$i<count($cart_items);$i++)
		{
		$cart_item = explode("-", $cart_items[$i]);
		
		//if(!$this->get_product_stock_available($cart_item[0]))
		//continue;
		$k++;
		
		
		$res1=$db->execute_query("select shipping_class from ".TABLE_PREFIX."product where id=?",array($cart_item[0]));
		$row1=$res1->fetch_assoc();
		
		$prod_id=$cart_item[0];
		$prod_name=$this->get_product_name($prod_id);
		$prod_image=$this->get_product_image($prod_id);
		$prod_quantity=$cart_item[1];
		$prod_price=$this->get_product_pricing($prod_id);
		$shipping_class=$row1['shipping_class'];
		
		
		list($widthimage,$heightimage) = @getimagesize($this->get_product_image($prod_id));
		$dimension=$this->get_image_dimension($widthimage,$heightimage,6);
		$dimensionarray=explode('_',$dimension);
		

		
		$res2=$db->execute_query("select * from ".TABLE_PREFIX."shipping_classes where id=?",array($shipping_class));
		$row2=$res2->fetch_assoc();
		

		$base_country=Settings::get_instance()->read('country');
		
		
		$localpickup=$row2['local_pickup'];
		if($country != $base_country)
		{
			$shipping_type=$row2['inat_shipping_type'];
			
			if($shipping_type==0 || $shipping_type==1)
			$shipping_cost=0;
			else if($shipping_type==2)
			$shipping_cost=$row2['inat_price'];
			else if($shipping_type==3 && $cart_item[1]>$row2['inat_free_units'] && $row2['inat_free_units']>0 )
			{
					$shipping_cost=0;
					$shipping_type=1;
			}
			else
				$shipping_cost=$row2['inat_price']+(($cart_item[1]-1)*$row2['inat_price_per_additional_unit']);
			
		}
		else
		{
			$local=0;
			$supported_zipcodes= explode(",", $row2['local_pickup_zipcodes']);
				
			for($j=0;$j< count($supported_zipcodes);$j++)
			{
				if(strpos($supported_zipcodes[$j],':') >0)
				{
					if($supported_zipcodes[$j][0]=='/' && $supported_zipcodes[$j][strlen($supported_zipcodes[$j])-1]=='/')
					{
						$return=preg_match_all($supported_zipcodes[$j].'i',$zipcode,$matches);
						if($return >0)
						{
							$local=1;
							break;
						}
						else
							continue;
					}
					
					$supported_zipcode = explode(":", $supported_zipcodes[$j]);
							
					if($zipcode >=$supported_zipcode[0] && $zipcode <=$supported_zipcode[1])
					{
						$local=1;
						break;
					}
				}
				elseif($supported_zipcodes[$j]==$zipcode)
				{
					$local=1;
					break;
				}
		}
		
		
		
		if($local==1)
		{
			$shipping_type=$row2['local_shipping_type'];
			
			if($shipping_type==1)
			$shipping_cost=0;
			else if($shipping_type==2)
			$shipping_cost=$row2['local_price'];
			else if($shipping_type==3 && $cart_item[1]>$row2['local_free_units'] && $row2['local_free_units']>0)
			{
					$shipping_cost=0;
					$shipping_type=1;
			}
			else
				$shipping_cost=$row2['local_price']+(($cart_item[1]-1)*$row2['local_price_per_additional_unit']);
		}
		else
		{
			$shipping_type=$row2['nat_shipping_type'];
		
			if($shipping_type==0)
			$shipping_cost=0;
			else if($shipping_type==1)
			$shipping_cost=0;
			else if($shipping_type==2)
			$shipping_cost=$row2['nat_price'];
			else if($shipping_type==3 && $cart_item[1]>$row2['nat_free_units'] && $row2['nat_free_units']>0)
			{
					$shipping_cost=0;
					$shipping_type=1;
			}
			else
				$shipping_cost=$row2['nat_price']+(($cart_item[1]-1)*$row2['nat_price_per_additional_unit']);
		}
			
		}
		
		$total_item_cost=$total_item_cost+($prod_quantity*$prod_price);
		$total_shipping_cost=$total_shipping_cost+$shipping_cost;
		$sub_total_cost=($prod_quantity*$prod_price)+$shipping_cost;
		$grand_total_cost=$grand_total_cost+$sub_total_cost;
		
		
		if($JSStr !='')
		$JSStr.=',';
		
		$JSStr.='{"id":'.$prod_id.',"name":"'.$prod_name.'","image":"'.$prod_image.'","width":"'.$dimensionarray[0].'","height":"'.$dimensionarray[1].'","quantity":'.$prod_quantity.',"price":'.$prod_price.',"shipping_cost":'.$shipping_cost.',"sub_total_cost":'.$sub_total_cost.',"shipping_type":'.$shipping_type.',"localpickup":'.$localpickup.',"subtotal":'.$sub_total_cost.'}';
		
		}
		
		if($JSStr !='')
		$JSStr='['.$JSStr.']';
		else
		$JSStr=0;
		
		$JSString='{"shopping":'.$JSStr.',"total_items":'.$k.',"total_item_cost":'.$total_item_cost.',"total_shipping_cost":'.$total_shipping_cost.',"grand_total_cost":'.$grand_total_cost.'}';
		

		
		
		$this->set_variable('JSString',$JSString,0);
		
		$this->set_variable('shpaddress',$address_id);
		
	}	
};