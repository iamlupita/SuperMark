<?php
include_once COMMON_DIR_PATH.DS.'helpers'.DS."login-helper.php";
include_once COMMON_DIR_PATH.'helpers'.DS."utility-helper.php";

class SalesController extends AppController
{
	function before_execute()
	{
		if(LoginHelper::validate_admin_login()==0)
		{
			$this->flash($this->get_message('login failed'), $this->make_url('index/index'),0);
		}
	}

	function manage_action()
	{
		$this->set_title($this->get_label('manage orders'));
		
		if($_POST)
			$status=$this->read_post_param("status");
		else
			$status=$this->read_page_param(1);
		
		if(!isset($status) || $status==0)
		$cnd="";
		else
		$cnd="where status=$status";
		

		$this->set_variable("status",$status);
	
		$sql="select * from ".TABLE_PREFIX."order $cnd order by id desc";
		$pagination = new Pagination($sql);
		$res=$pagination->get_result();
		$this->set_result("res",$res);
		$this->set_variable("pagination",$pagination->links(),0);
	
		$db= DBLayer::get_instance();
		$res=$db->execute_query("select * from ".TABLE_PREFIX."shippingcompany where status=1 order by id desc");
		$this->set_result("comp",$res);
	}
	
	function details_action()
	{
		$this->set_title($this->get_label('order details'));
		$this->disable_notice_area();
		$order_id=$this->read_page_param(1);
		$db= DBLayer::get_instance();
		$sql="select or1.id as or_id,or1.user_id,or1.order_date,or1.payment_method,or1.grand_cost,or1.payment_date,or1.billing_address_id,or1.shipping_address_id,or1.status as or_status,o.*,s.id as shipment_id,s.order_item_id,s.track_id,s.url,s.ship_id,s.ship_date,s.exp_delivery_date,s.recieved_date,s.quantity as ship_quantity,s.status from ".TABLE_PREFIX."order or1 JOIN ".TABLE_PREFIX."order_items o ON or1.id=o.order_id LEFT JOIN ".TABLE_PREFIX."shipment_details s ON o.id=s.order_item_id where o.order_id=? group by o.id order by o.id asc";
		$res=$db->execute_query($sql,array($order_id));
		$this->set_result("res",$res);
		
		$res=$db->execute_query("select * from ".TABLE_PREFIX."shippingcompany where status=1 order by id desc");
		$this->set_result("comp",$res);
	}
		
		function get_return_details_action()
		{
			$shipment_id=$this->read_page_param(1);
			$db= DBLayer::get_instance();
		
			$order_item_id=$db->read_single_column("select order_item_id from ".TABLE_PREFIX."shipment_details where id=? order by id desc",array($shipment_id));
		
			$this->set_variable("shipment_id",$shipment_id);
			$this->set_variable("order_item_id",$order_item_id);
		
			$res2=$db->execute_query("select * from ".TABLE_PREFIX."order_item_return where shipment_id=? order by id desc",array($shipment_id));
			$this->set_result("return_items",$res2);
		}
		function edit_return_details_action()
		{
			$id=$this->read_page_param(1);
			$redirect_page=intval($this->read_page_param(2));
			$paramstatus=intval($this->read_page_param(3));
			
			
			

		
			$db= DBLayer::get_instance();
			
			if($_POST['sub'])
			{
				$id=$_POST['return_id'];
				$amount=$_POST['amount'];
				$remarks=$_POST['remarks'];
				$status=$_POST['status'];
				
				$redirect_page=intval($_POST['redirect_page']);
				$paramstatus=intval($this->read_post_param('paramstatus'));
				
				
				$order_id=$_POST['order_id'];
				if(($status==2 && $amount=="") || $remarks=="" || $status=="")
				{
					if($redirect_page==0)
					$this->flash($this->get_message('mandatory'), $this->make_url('sales/returns/'.$paramstatus),0);
					else if($redirect_page==1)
					$this->set_notice('mandatory');
			
				}
				else
				{
					
					if($amount =='')
					$amount=0;
										
					$t=time();
					$db->execute_query("update ".TABLE_PREFIX."order_item_return set amount=?,admin_remarks=?,status=?,solved_date=? where id=?",array($amount,$remarks,$status,$t,$id));
		
					if($status==2) // Approved
					{
						
						$sql="select a.pro_id,b.user_id,c.order_item_id,c.quantity from ".TABLE_PREFIX."order_items a JOIN ".TABLE_PREFIX."order b ON b.id=a.order_id JOIN " .TABLE_PREFIX."order_item_return c ON a.id=c.order_item_id where c.id=$id group by b.id";
						$res1=$db->execute_query($sql);
						$result1=$res1->fetch_assoc();
						$uid=$result1['user_id'];
						$pro_id=$result1['pro_id'];
						$quantity=$result1['quantity'];
						
						$order_url=$this->make_base_url('order/details/'.$order_id);
						$uname=$this->get_user_name($uid);
						$email=$this->get_user_email($uid);
						$prod_name=$this->get_product_name($pro_id);
						
						$res1=$db->execute_query("select sub,body from ".TABLE_PREFIX."emailtemplates where id=10");// to user.. Return Request Approved
						$result1=$res1->fetch_assoc();
						$subject=$result1['sub'];
						$message=$result1['body'];
			
						$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
						$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
			
						$message=str_replace("{NAME}",$uname,$message);
						$message=str_replace("{ORDERURL}",$order_url,$message);
						$message=str_replace("{ITEMNAME}",$prod_name,$message);
						$message=str_replace("{QUANTITY}",$quantity,$message);
						$message=str_replace("{AMOUNT}",$this->get_money_format($amount),$message);
						$message=str_replace("{REMARKS}",$remarks,$message);
			
						UtilityHelper::send_mail($email,$subject,nl2br($message));
					}
					else if($status==3) // Rejected
					{
					
						$sql="select a.pro_id,b.user_id,c.order_item_id,c.quantity from ".TABLE_PREFIX."order_items a JOIN ".TABLE_PREFIX."order b ON b.id=a.order_id JOIN " .TABLE_PREFIX."order_item_return c ON a.id=c.order_item_id where c.id=$id group by b.id";
						$res1=$db->execute_query($sql);
						$result1=$res1->fetch_assoc();
						$uid=$result1['user_id'];
						$pro_id=$result1['pro_id'];
						$quantity=$result1['quantity'];
					
						$order_url=$this->make_base_url('order/details/'.$order_id);
						$uname=$this->get_user_name($uid);
						$email=$this->get_user_email($uid);
						$prod_name=$this->get_product_name($pro_id);
					
						$res1=$db->execute_query("select sub,body from ".TABLE_PREFIX."emailtemplates where id=11");// to user.. Return Request Rejected
						$result1=$res1->fetch_assoc();
						$subject=$result1['sub'];
						$message=$result1['body'];
							
						$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
						$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
							
						$message=str_replace("{NAME}",$uname,$message);
						$message=str_replace("{ORDERURL}",$order_url,$message);
						$message=str_replace("{ITEMNAME}",$prod_name,$message);
						$message=str_replace("{QUANTITY}",$quantity,$message);
						$message=str_replace("{REMARKS}",$remarks,$message);
							
						UtilityHelper::send_mail($email,$subject,nl2br($message));
					}
					
					
					
					if($redirect_page==0)
					$this->flash($this->get_message('return details updated'), $this->make_url('sales/returns/'.$paramstatus));
					else if($redirect_page==1)
					{
						echo '<script type="text/javascript">parent.window.location.href=parent.window.location.href;</script>';
						die;
					}
				}
		
			}
			
			$sql="select b.*,a.id as return_id,a.quantity as qty,a.reason,a.amount,a.admin_remarks,a.shipment_id,a.status as stat from ".TABLE_PREFIX."order_item_return a, ".TABLE_PREFIX."order_items b where a.order_item_id=b.id and a.id=? order by a.id asc";
			$res=$db->execute_query($sql,array($id));
			$this->set_result("res",$res);
			
			
			$this->set_variable("paramstatus",$paramstatus);
			$this->set_variable("redirect_page", $redirect_page);
		}
		function edit_shipping_details_action()
		{
			$shipment_id=$this->read_page_param(1);
			$order_id=$this->read_page_param(2);
			$order_item_id=$this->read_page_param(3);
			$localpickup=intval($this->read_page_param(4));
				
			$db= DBLayer::get_instance();
			
			$res=$db->execute_query("select * from ".TABLE_PREFIX."shippingcompany where status=1 order by id desc");
			$this->set_result("comp",$res);
			if($_POST['sub'])
			{
				$shipment_id=$this->read_post_param('shipment_id');
			    $order_id=$this->read_post_param('order_id');
			    $order_item_id=$this->read_post_param('order_item_id');
			    $localpickup=intval($this->read_post_param('localpickup'));
				
			    
			    if($localpickup ==0)
			    {
			    
					$company=$_POST['ship_id'];
					$track_id=$_POST['track_id'];
					$url=$_POST['url'];
					$quantity=$_POST['quantity'];
					$ship_date=$_POST['ship_date'];
					$exp_delivery_date=$_POST['exp_delivery_date'];
					$status=$_POST['status'];
					
					$startDateArray=explode('/',$ship_date);
					$ship_day = $startDateArray[0];
					$ship_month = $startDateArray[1];
					$ship_year = $startDateArray[2];
					$shipp_date = gmmktime(0,0,0,$ship_month,$ship_day,$ship_year);
						
					$startDateArray=explode('/',$exp_delivery_date);
					$exp_day = $startDateArray[0];
					$exp_month = $startDateArray[1];
					$exp_year = $startDateArray[2];
					$exp_date = gmmktime(0,0,0,$exp_month,$exp_day,$exp_year);
					
			    }
				
				
				$recieved_date=$_POST['recieved_date'];
				
				$startDateArray=explode('/',$recieved_date);
				$rec_day = $startDateArray[0];
				$rec_month = $startDateArray[1];
				$rec_year = $startDateArray[2];
				$rec_date = gmmktime(0,0,0,$rec_month,$rec_day,$rec_year);
				
				
				if($localpickup ==0 && ($company=="" || $track_id=="" || $url=="" || $ship_date=="" || $exp_delivery_date=="" || $status=="" || $quantity==0 || $quantity=="" || (($status=="2" || $status=="3") && $recieved_date=="")))
				{
					$this->set_notice("mandatory");
				}
				else if($localpickup ==1 && $recieved_date =='')
				{
					$this->set_notice("mandatory");
				}
				else if($localpickup ==0 && $shipp_date > $exp_date)
				{
					$this->set_notice("expected date exceeds shipping date");
				}
				else if($localpickup ==0 && ($rec_date !="" && $rec_date!=0 && $shipp_date>$rec_date))
				{
					$this->set_notice("received date exceeds shipping date");
				}
				else{
					
					
					if($localpickup ==0)
					{
						if(substr( $url, 0, 7 ) != "http://")
						{
							if(substr( $url, 0, 8 ) != "https://")
							$url="http://".$url;
						}
					}
					
					
					
					$order_item_quantity=$this->get_orderitem_quantity($order_item_id);
					$order_item_shipped_quantity=$this->get_orderitem_shipped_quantity($order_item_id);
					
					if($shipment_id==0)
					{
						
						if($localpickup ==0 && $quantity >($order_item_quantity-$order_item_shipped_quantity))
						{
							$this->set_notice('shipping quantity exceeded');
						}
						else
						{
							
							if($localpickup ==0)
							{
							
							if($status==1)
							$rec_date=0;
							
							$sql="INSERT INTO ".TABLE_PREFIX."shipment_details (orderid,order_item_id,ship_id,track_id,url,quantity,ship_date,exp_delivery_date,recieved_date,status) values (?,?,?,?,?,?,?,?,?,?)";
							$res=$db->execute_query($sql,array($order_id,$order_item_id,$company,$track_id,$url,$quantity,$shipp_date,$exp_date,$rec_date,$status));
							
							$db->execute_query("UPDATE ".TABLE_PREFIX."order_items SET shipped_quantity=shipped_quantity+? WHERE id=?",array($quantity,$order_item_id));
							
							$this->set_notice('shipping details added',1);
							
							if($status==1) // Shipped
							{
								$uid=$this->get_userid_from_orderid($order_id);
								$uname=$this->get_user_name($uid);
								$email=$this->get_user_email($uid);
								$order_url=$this->make_base_url('order/details/'.$order_id);
								$comp_name=$this->get_shipping_company_name($company);
								
								
								$prod_name=$this->get_product_name($this->get_prodid_from_order_items($order_item_id));
								
								$res1=$db->execute_query("select sub,body from ".TABLE_PREFIX."emailtemplates where id=8");// to user.. Item Shipped
								$result1=$res1->fetch_assoc();
								$subject=$result1['sub'];
								$message=$result1['body'];
									
								$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
								$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
									
								$message=str_replace("{NAME}",$uname,$message);
								$message=str_replace("{ORDERURL}",$order_url,$message);
								$message=str_replace("{ITEMNAME}",$prod_name,$message);
								$message=str_replace("{QUANTITY}",$quantity,$message);
								$message=str_replace("{SHIPPINGCOMPANY}",$comp_name,$message);
								$message=str_replace("{TRACKINGID}",$track_id,$message);
								$message=str_replace("{TRACKINGURL}",$url,$message);
									
								UtilityHelper::send_mail($email,$subject,nl2br($message));
									
								
							}
							else if($status==2) // Delivered
							{
								$uid=$this->get_userid_from_orderid($order_id);
								$uname=$this->get_user_name($uid);
								$email=$this->get_user_email($uid);
								$order_url=$this->make_base_url('order/details/'.$order_id);
								$comp_name=$this->get_shipping_company_name($company);
								
								
								$prod_name=$this->get_product_name($this->get_prodid_from_order_items($order_item_id));
								
								$res1=$db->execute_query("select sub,body from ".TABLE_PREFIX."emailtemplates where id=9");// to user.. Item Delivered
								$result1=$res1->fetch_assoc();
								$subject=$result1['sub'];
								$message=$result1['body'];
									
								$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
								$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
									
								$message=str_replace("{NAME}",$uname,$message);
								$message=str_replace("{ORDERURL}",$order_url,$message);
								$message=str_replace("{ITEMNAME}",$prod_name,$message);
								$message=str_replace("{QUANTITY}",$quantity,$message);
								$message=str_replace("{SHIPPINGCOMPANY}",$comp_name,$message);
								$message=str_replace("{TRACKINGID}",$track_id,$message);
								$message=str_replace("{TRACKINGURL}",$url,$message);
									
								UtilityHelper::send_mail($email,$subject,nl2br($message));
							}
							
							echo '<script type="text/javascript">parent.window.location.href=parent.window.location.href;</script>';
							die;
							}
							else if($localpickup ==1)
							{
								
								$sql="INSERT INTO ".TABLE_PREFIX."shipment_details (orderid,order_item_id,quantity,ship_date,exp_delivery_date,recieved_date,status) values (?,?,?,?,?,?,?)";
								$res=$db->execute_query($sql,array($order_id,$order_item_id,$order_item_quantity,$rec_date,$rec_date,$rec_date,2));
								
								$db->execute_query("UPDATE ".TABLE_PREFIX."order_items SET shipped_quantity=? WHERE id=?",array($order_item_quantity,$order_item_id));
								
								$this->set_notice('shipping details added',1);
								
								echo '<script type="text/javascript">parent.window.location.href=parent.window.location.href;</script>';
								die;
								
							}
						}
					}
					else
					{
						
						if($localpickup ==0)
						{
						
						
						$qty_from_shdtls_exptid=$this->get_qty_from_shdtls_exptid($order_item_id,$shipment_id);
						
						$new_shipment_qty=$quantity+$qty_from_shdtls_exptid;
							
						$max_qty=$order_item_quantity-$qty_from_shdtls_exptid;
						
						if($localpickup ==0 && $max_qty < $quantity)
						{
							$this->set_notice('shipping quantity exceeded');
						}
						else
						{
							
							if($status==1)
							$rec_date=0; 
							
							$db->execute_query("UPDATE ".TABLE_PREFIX."shipment_details SET ship_id=?,track_id=?,url=?,quantity=?,ship_date=?,exp_delivery_date=?,recieved_date=?,status=? WHERE id=?",array($company,$track_id,$url,$quantity,$shipp_date,$exp_date,$rec_date,$status,$shipment_id));
							
							$db->execute_query("UPDATE ".TABLE_PREFIX."order_items SET shipped_quantity=? WHERE id=?",array($new_shipment_qty,$order_item_id));
								
							
							$this->set_notice('shipping details updated',1);
							
							if($status==1) // Shipped
							{
								$uid=$this->get_userid_from_orderid($order_id);
								$uname=$this->get_user_name($uid);
								$email=$this->get_user_email($uid);
								$order_url=$this->make_base_url('order/details/'.$order_id);
								$comp_name=$this->get_shipping_company_name($company);
							
							
								$prod_name=$this->get_product_name($this->get_prodid_from_order_items($order_item_id));
							
								$res1=$db->execute_query("select sub,body from ".TABLE_PREFIX."emailtemplates where id=8");// to user.. Item Shipped
								$result1=$res1->fetch_assoc();
								$subject=$result1['sub'];
								$message=$result1['body'];
									
								$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
								$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
									
								$message=str_replace("{NAME}",$uname,$message);
								$message=str_replace("{ORDERURL}",$order_url,$message);
								$message=str_replace("{ITEMNAME}",$prod_name,$message);
								$message=str_replace("{QUANTITY}",$quantity,$message);
								$message=str_replace("{SHIPPINGCOMPANY}",$comp_name,$message);
								$message=str_replace("{TRACKINGID}",$track_id,$message);
								$message=str_replace("{TRACKINGURL}",$url,$message);
									
								UtilityHelper::send_mail($email,$subject,nl2br($message));
									
							
							}
							else if($status==2) // Delivered
							{
								$uid=$this->get_userid_from_orderid($order_id);
								$uname=$this->get_user_name($uid);
								$email=$this->get_user_email($uid);
								$order_url=$this->make_base_url('order/details/'.$order_id);
								$comp_name=$this->get_shipping_company_name($company);
							
							
								$prod_name=$this->get_product_name($this->get_prodid_from_order_items($order_item_id));
							
								$res1=$db->execute_query("select sub,body from ".TABLE_PREFIX."emailtemplates where id=9");// to user.. Item Delivered
								$result1=$res1->fetch_assoc();
								$subject=$result1['sub'];
								$message=$result1['body'];
									
								$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
								$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
									
								$message=str_replace("{NAME}",$uname,$message);
								$message=str_replace("{ORDERURL}",$order_url,$message);
								$message=str_replace("{ITEMNAME}",$prod_name,$message);
								$message=str_replace("{QUANTITY}",$quantity,$message);
								$message=str_replace("{SHIPPINGCOMPANY}",$comp_name,$message);
								$message=str_replace("{TRACKINGID}",$track_id,$message);
								$message=str_replace("{TRACKINGURL}",$url,$message);
									
								UtilityHelper::send_mail($email,$subject,nl2br($message));
							}
							
							echo '<script type="text/javascript">parent.window.location.href=parent.window.location.href;</script>';
							die;
						
						}
						
						}
						else if($localpickup ==1)
						{
						
							$db->execute_query("UPDATE ".TABLE_PREFIX."shipment_details SET quantity=?,ship_date=?,exp_delivery_date=?,recieved_date=?,status=? WHERE id=?",array($order_item_quantity,$rec_date,$rec_date,$rec_date,2,$shipment_id));
							
							$db->execute_query("UPDATE ".TABLE_PREFIX."order_items SET shipped_quantity=? WHERE id=?",array($order_item_quantity,$order_item_id));
														
							$this->set_notice('shipping details updated',1);
							
							echo '<script type="text/javascript">parent.window.location.href=parent.window.location.href;</script>';
							die;
						}
						
					}
				
				}
				
			}
			else
			{
				$track_id="";
				$url="";
				$company="";
				$ship_date="";
				$exp_delivery_date="";
				$recieved_date="";
				$quantity="";
				$status="";
				if($shipment_id !=0)
				{
					
					$res=$db->execute_query("select * from ".TABLE_PREFIX."shipment_details where id=?",array($shipment_id));
					
					while($row=$res->fetch_assoc())
					{
						$track_id=$row['track_id'];
						$url=$row['url'];
						$company=$row['ship_id'];
						$shipp_date=$row['ship_date'];
						$exp_date=$row['exp_delivery_date'];
						$rec_date=$row['recieved_date'];
						$quantity=$row['quantity'];
						$status=$row['status'];
					}
					
					$this->set_result("res",$res);
				}
				
			}
				
			$this->set_variable("shipment_id", $shipment_id);
			$this->set_variable("order_id", $order_id);
			$this->set_variable("order_item_id", $order_item_id);
			$this->set_variable("localpickup", $localpickup);
			
			
			
			
			$this->set_variable("track_id", $track_id);
			$this->set_variable("url", $url);
			$this->set_variable("ship_id", $company);
			$this->set_variable("ship_date", $shipp_date);
			$this->set_variable("exp_delivery_date", $exp_date);
			$this->set_variable("recieved_date", $rec_date);
			$this->set_variable("quantity", $quantity);
			$this->set_variable("status", $status);
			
		}

	function items_to_ship_action()
	{
		$this->set_title($this->get_label('manage orders'));
	
		$db= DBLayer::get_instance();
		
		$sql="select a.*,b.user_id,b.shipping_address_id from ".TABLE_PREFIX."order_items a, ".TABLE_PREFIX."order b where b.id=a.order_id and a.quantity >a.shipped_quantity and b.status=? order by a.id ASC";
		$pagination = new Pagination($sql,array(2));
		$res=$pagination->get_result();
		$this->set_result("res",$res);
		$this->set_variable("pagination",$pagination->links(),0);
	}

	function items_to_deliver_action()
	{
		$this->set_title($this->get_label('manage orders'));
	
		$db= DBLayer::get_instance();
		
		$sql="select a.*,b.user_id,b.shipping_address_id,c.quantity as shippment_quantity from ".TABLE_PREFIX."order_items a JOIN ".TABLE_PREFIX."order b ON b.id=a.order_id LEFT JOIN " .TABLE_PREFIX."shipment_details c ON a.id=c.order_item_id where c.status=? and b.status=? order by a.id ASC";
		$pagination = new Pagination($sql,array(1,2));
		
		$res=$pagination->get_result();
		$this->set_result("res",$res);
		$this->set_variable("pagination",$pagination->links(),0);
	}
	
	function returns_action()
	{
		$this->set_title($this->get_label('manage returns'));
		
		if($_POST)
		$paramstatus=intval($this->read_post_param('paramstatus'));
		else 
		$paramstatus=intval($this->read_page_param(1));
		
		$statusstr='';
		if($paramstatus >0)
		$statusstr=' AND a.status='.$paramstatus.' ';
		
		$this->set_variable('paramstatus',$paramstatus);
		
		$sql="select b.*,a.id as return_id,a.quantity as qty,a.reason,a.amount,a.admin_remarks,a.shipment_id,a.status as stat,a.issue_date,a.solved_date from ".TABLE_PREFIX."order_item_return a, ".TABLE_PREFIX."order_items b where a.order_item_id=b.id ".$statusstr." order by a.id asc";
		$pagination = new Pagination($sql,array());
		$res=$pagination->get_result();
		$this->set_result("res",$res);
		$this->set_variable("pagination",$pagination->links(),0);
	}
	
	
	function update_status_action()
	{
		$status=$this->read_page_param(1);
		$id=$this->read_page_param(2);
	
		$db=DBLayer::get_instance();
		$t=0;
		
		if($status==2)
		$t=time();
		
		$db->execute_query("update ".TABLE_PREFIX."order set status=?,payment_date=? where id=?",array($status,$t,$id));
		
		
		if($status==2)
		{
			$res0=$db->execute_query("select pro_id,quantity from ".TABLE_PREFIX."order_items where order_id=$id");
			while($row0=$res0->fetch_assoc())
			{
				if($row0['pro_id'] !="" && $row0['quantity'] !="")
				{
					$currentstock=$db->read_single_column("select prod_stock from ".TABLE_PREFIX."product where id=?",array($row0['pro_id']));
					$newstock=$currentstock-$row0['quantity'];
					if($newstock < 0)
					$newstock=0;
					
					$db->execute_query("UPDATE ".TABLE_PREFIX."product SET prod_stock=? WHERE id=?",array($newstock,$row0['pro_id']));
				}
			}
		}
			
		exit;
	}
	
	function get_shipment_details_action()
	{
		$id=$this->read_page_param(1);
		$db=DBLayer::get_instance();
		
		$res=$db->execute_query("select * from ".TABLE_PREFIX."shipment_details  where id=?",array($id));

		$this->set_result("res",$res);
	}
	
	function get_user_address_details_action()
	{
		$id=$_POST['id'];
		
		$db=DBLayer::get_instance();
		$sql="select * from ".TABLE_PREFIX."user_address  where id=?";
		$res=$db->execute_query($sql,array($id));

		$this->set_result("res",$res);
	}
	
	function get_return_summary_action()
	{
		$id=$this->read_page_param(1);
		$db=DBLayer::get_instance();
		$res=$db->execute_query("select * from ".TABLE_PREFIX."order_item_return  where id=?",array($id));

		$this->set_result("res",$res);
	}
	
	function shipping_details_action()
	{
		$order_item_id=$this->read_page_param(1);
	
		$db= DBLayer::get_instance();
		
		$sql="select o.*,s.id as shipment_id,s.order_item_id,s.track_id,s.url,s.ship_id,s.ship_date,s.exp_delivery_date,s.recieved_date,s.quantity as ship_quantity,s.status from ".TABLE_PREFIX."order_items o JOIN ".TABLE_PREFIX."shipment_details s ON o.id=s.order_item_id where o.id=? group by s.id order by o.id asc";
		$res1=$db->execute_query($sql,array($order_item_id));
		$this->set_result("shipping",$res1);
	
	}
	


	function payments_action()
	{
		$db=DBLayer::get_instance();
		$query = "select * from ".TABLE_PREFIX."payment_summary ORDER BY id desc";
		$pagination = new Pagination($query,array());
		$res=$pagination->get_result();
		$this->set_result("res",$res);
		$this->set_variable("pagination",$pagination->links(),0);
	
	}
	
	

	function payment_details_action()
	{
		$this->set_title($this->get_label('payment details'));
	
		$paymentid=$this->read_page_param(1);
	
	
		if(!$this->get_payment_exists($paymentid))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('sales/payments'),0);
			exit;
		}
	
	
		$db= DBLayer::get_instance();
		$query = "select a.*,b.order_id from ".TABLE_PREFIX."paypal_ipn a JOIN ".TABLE_PREFIX."payment_summary b ON a.payment_id=b.id where a.payment_id=? ORDER BY a.id desc";
		$res=$db->execute_query($query,array($paymentid));
		$this->set_result('res', $res);
			
	
	}
	function print_invoice_action()
	{
		header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . date("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		
		$this->disable_notice_area();
		$orderid=$this->read_post_param('orderid');
		$shipmentidlist=$this->read_post_param('list');
		
		$itemstr='';
		$shipmentstr='';
		$shipmentidlistarray=explode('-',$shipmentidlist);
		$shipmentidlistarraycount=count($shipmentidlistarray);
		$itarray=array();
		for($i=0;$i < $shipmentidlistarraycount;$i++)
		{
			if($shipmentidlistarray[$i] !='')
			{
				$shipmentidlistdata=explode('_',$shipmentidlistarray[$i]);
				$itemid=$shipmentidlistdata[0];
				$quantity=$shipmentidlistdata[1];
				
				$itarray[0][$itemid]=$quantity;
			}
		}
		
		$qstring='';
		
		foreach ($itarray[0] as $key => $value)
		{
			if($qstring !='')
			$qstring.=' OR ';
			
			$qstring.=' ( oi.pro_id = '.$key.') ';
		} 
		
		if($qstring !='')
		$qstring=' AND ('.$qstring.') ';
		
		if($this->get_order_exists($orderid))
		{
			
			
			$this->set_variable('orderid',$orderid);
			
			
			
		$db= DBLayer::get_instance();
		$sql="SELECT oi.*,o.id as orderid,o.order_date,o.payment_method,o.grand_cost,o.payment_date,o.billing_address_id,o.shipping_address_id,o.status as ostatus
		FROM  
		".TABLE_PREFIX."order o INNER JOIN ".TABLE_PREFIX."order_items oi ON o.id=oi.order_id  
		WHERE o.id=? ".$qstring." ORDER BY oi.id ASC";
		
		$res=$db->execute_query($sql,array($orderid));
		
		
		$this->set_result("res",$res);

		
		
		$this->set_array('itarray',$itarray);
		
		}
		else
		{
			echo '';
			exit;
		}
		
	}
	
};