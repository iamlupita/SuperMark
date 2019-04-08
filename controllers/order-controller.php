<?php
include_once COMMON_DIR_PATH.'helpers'.DS."login-helper.php";
include_once COMMON_DIR_PATH.DS.'helpers'.DS."utility-helper.php";

class OrderController extends AppController
{

	function before_execute()
	{
		if(LoginHelper::validate_user_login()==0)
		$this->flash($this->get_message('login to continue'), $this->make_url('user/login'),0);
	}
	
	
	function details_action()
	{
		$order_id=$this->read_page_param(1);
		$this->set_title($this->get_label('order details'));
		$db= DBLayer::get_instance();
		$user_id=$this->read_cookie_param(COOKIE_LOGINID);
		
		$sql="select or1.id as or_id,or1.user_id,or1.order_date,or1.payment_method,or1.grand_cost,or1.payment_date,or1.billing_address_id,or1.shipping_address_id,or1.status as or_status,o.*,s.id as shipment_id,s.order_item_id,s.track_id,s.url,s.ship_id,s.ship_date,s.exp_delivery_date,s.recieved_date,s.quantity as ship_quantity,s.status from ".TABLE_PREFIX."order or1 JOIN ".TABLE_PREFIX."order_items o ON or1.id=o.order_id LEFT JOIN ".TABLE_PREFIX."shipment_details s ON o.id=s.order_item_id where o.order_id=? group by o.id order by o.id asc";
		$res2=$db->execute_query($sql,array($order_id));
		$this->set_result("orderitem",$res2);
		
		$sql="select * from ".TABLE_PREFIX."shippingcompany where status=1 order by id desc";
		$res=$db->execute_query($sql);
		$this->set_result("comp",$res);
		
		$user_id=$this->read_cookie_param(COOKIE_LOGINID);
		$this->set_variable("user_id", $user_id);
	}
	
	function get_return_details_action()
	{
		$shipment_id=$this->read_page_param(1);
		$expired=$this->read_page_param(2);//1-return request expired
		$db= DBLayer::get_instance();
		
		$order_item_id=$db->read_single_column("select order_item_id from ".TABLE_PREFIX."shipment_details where id=?",array($shipment_id));
		
		$this->set_variable("shipment_id",$shipment_id);
		$this->set_variable("order_item_id",$order_item_id);
		$this->set_variable("expired",$expired);
		
		$sql="select * from ".TABLE_PREFIX."order_item_return where shipment_id=?";
		$res2=$db->execute_query($sql,array($shipment_id));
		$this->set_result("return_items",$res2);
	}

	function edit_return_details_action()
	{
		
		$return_id=$this->read_page_param(1);
		$shipment_id=$this->read_page_param(2);
		$order_item_id=$this->read_page_param(3);
	
		$db= DBLayer::get_instance();
			
		$stat="";
		
		if($_POST)
		{
			$order_item_id=$_POST['order_item_id'];
			$shipment_id=$_POST['shipment_id'];
			$return_id=$_POST['return_id'];
			$qty=$_POST['qty'];
			$reason=$_POST['reason'];
				
			$order_id=$this->get_orderid_from_orderitemid($order_item_id);
				
			if($qty=="" || $qty==0 || $reason=="")
			{
				$this->set_notice("mandatory");
			}
			else
			{
				$db= DBLayer::get_instance();
				$res=$db->execute_query("select * from ".TABLE_PREFIX."order_items where id=?",array($order_item_id));
				$row=$res->fetch_assoc();
				$t=time();
				
				$current_return_quantity=$this->get_return_quantity($order_item_id,$shipment_id);
			
				$ship_quantity=$db->read_single_column("select quantity from ".TABLE_PREFIX."shipment_details where id=?",array($shipment_id));
			
				
					if($return_id==0 || $return_id==""){
						
						if($ship_quantity < $qty)
						{
							$this->set_notice("quantity exceeds the limit");
						}
						else
						{
						
							$sql="INSERT INTO ".TABLE_PREFIX."order_item_return (`orderid`,`order_item_id`,`reason`,`quantity`,`issue_date`,`shipment_id`,`status`) values (?,?,?,?,?,?,?)";
							$res2=$db->execute_query($sql,array($order_id,$order_item_id,$reason,$qty,$t,$shipment_id,1));
							
							$admin_email=Settings::get_instance()->read('general_notification_email');
							$order_url=$this->make_base_url('sales/details/'.$order_id,ADMIN_DIR);
							$prod_name=$this->get_product_name($this->get_prodid_from_order_items($order_item_id));
							
							$query1="select sub,body from ".TABLE_PREFIX."emailtemplates where id=15";// to admin.. Return Request Created
							$res1=$db->execute_query($query1);
							$result1=$res1->fetch_assoc();
							$subject=$result1['sub'];
							$message=$result1['body'];
							
							$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
							$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
							
							$message=str_replace("{ORDERURL}",$order_url,$message);
							$message=str_replace("{ITEMNAME}",$prod_name,$message);
							$message=str_replace("{QUANTITY}",$qty,$message);
							$message=str_replace("{REASON}",$reason,$message);
								
							UtilityHelper::send_mail($admin_email,$subject,nl2br($message));
							
							echo "<script>parent.window.location.reload();</script>";die;
						
					}
					
					}
					else
					{
						
						$qty_from_retdtls_exptid=$this->get_qty_from_retdtls_exptid($order_item_id,$shipment_id,$return_id);
						
							
						$max_qty=$ship_quantity-$qty_from_retdtls_exptid;
						
						if($max_qty < $qty)
						{
							$this->set_notice('quantity exceeds the limit');
						}
						else{
							
							$sql="UPDATE ".TABLE_PREFIX."order_item_return set reason=?,quantity=? where id=? and status=?";
							$res2=$db->execute_query($sql,array($reason,$qty,$return_id,1));
							
							echo "<script>parent.window.location.reload();</script>";die;
						}
					}
			}
		}
		else {
			
			$qty="";$reason="";$stat="";
			
			$sql="select a.quantity as qty,a.reason,a.status as stat from ".TABLE_PREFIX."order_item_return a where a.order_item_id=? and a.id=? and a.status=?";
			$res=$db->execute_query($sql,array($order_item_id,$return_id,1));
			while($row=$res->fetch_assoc())
			{
				$qty=$row['qty'];
				$reason=$row['reason'];
				//$stat=$row['stat'];
			}
		}
		
		
		
		$stat=$db->read_single_column("select a.status as stat from ".TABLE_PREFIX."order_item_return a where a.order_item_id=? and a.id=? and a.status=?",array($order_item_id,$return_id,1));
		
		
		$this->set_variable("return_id",$return_id);
		$this->set_variable("shipment_id",$shipment_id);
		$this->set_variable("order_item_id",$order_item_id);
		
		
		$this->set_variable("qty",$qty);
		$this->set_variable("reason",$reason);
		$this->set_variable("stat",$stat);
	}
	
	function delete_return_details_action()
	{
		$id=$this->read_page_param(1);
		
		$db= DBLayer::get_instance();
		
		$order_item_id=$db->read_single_column("select order_item_id from ".TABLE_PREFIX."order_item_return where id=?",array($id));
		$order_id=$this->get_orderid_from_orderitemid($order_item_id);
			
		$res=$db->execute_query("delete from ".TABLE_PREFIX."order_item_return where id=? and status=?",array($id,1));
		
		$this->flash($this->get_message('return request deleted'), $this->make_url('order/details/'.$order_id));
		die;
	}

	
	function reorder_action()
	{

		$user=$this->read_cookie_param(COOKIE_LOGINID);
		$this->set_variable("userids",$user);
		
		$order_id=$this->read_page_param(1);
		$this->set_variable("order_id",$order_id);
		
		setcookie(COOKIE_REORDER_ITEMS,"",0,$this->get_base_path(),$this->get_base_domain());
			
		
		$db= DBLayer::get_instance();
		$prod_ids="";
		$res5=$db->execute_query("select pro_id from ".TABLE_PREFIX."order_items where order_id=?",array($order_id));
		while($row=$res5->fetch_assoc())
		{
			if($this->get_item_exists($row['pro_id'],1))
			{
				if($prod_ids !='')
				$prod_ids.=',';
				
				$prod_ids.=$row['pro_id'];
			}
		}
		
		if($prod_ids !="")
		{
			$res1=$db->execute_query("select id,prod_stock,sale_price,special_offer_price,status from ".TABLE_PREFIX."product where id IN(".$prod_ids.")");
			$this->set_result("cartitem",$res1);
			
			if($res1->get_num_records() ==0)
			{
				$this->flash($this->get_message('no products exists for reorder'), $this->make_url('user/home'),0);
				exit;
			}
		}
		
		
		if($prod_ids =='')
		{
			$this->flash($this->get_message('no products exists for reorder'), $this->make_url('user/home'),0);
			exit;
		}
	}
	
	function shipping_details_action()
	{
		$order_item_id=$this->read_page_param(1);
	
		$db= DBLayer::get_instance();
	
		$sql="select o.*,s.id as shipment_id,s.order_item_id,s.track_id,s.url,s.ship_id,s.ship_date,s.exp_delivery_date,s.recieved_date,s.quantity as ship_quantity,s.status from ".TABLE_PREFIX."order_items o JOIN ".TABLE_PREFIX."shipment_details s ON o.id=s.order_item_id where o.id=? group by s.id order by o.id asc";
		$res1=$db->execute_query($sql,array($order_item_id));
		$this->set_result("shipping",$res1);
	
	}
	
};
?>