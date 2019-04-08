<?php
include_once COMMON_DIR_PATH.'helpers'.DS."login-helper.php";
include_once COMMON_DIR_PATH.'helpers'.DS."utility-helper.php";

class PaymentController extends AppController
{
	function before_execute()
	{
		if($this->get_action()=="details")
		{
			if(LoginHelper::validate_user_login()==0)
			$this->flash($this->get_message('login to continue'), $this->make_url('user/login'),0);
		}
	}
	
	private $fullipn='';
	
	function paypal_ipn_action()
	{
		/*echo "IPN received at: " . date("r",time()) . "\n";
		
		$pp_domain = "www.paypal.com";
		$pp_validatorurl = "/cgi-bin/webscr";
		$req = 'cmd=_notify-validate';
		
		
		// Read the post from PayPal system and add 'cmd'
		$fullipnA = array();
		foreach ($_POST as $key => $value)
		{
			$encodedvalue = urlencode(stripslashes($value));
			$req .= "&$key=$encodedvalue";
		}
		
		$this->fullipn = $this->array2str(" : ", "\n", $fullipnA);
		
		
		// Post back to PayPal system to validate
		$header  = "POST $pp_validatorurl HTTP/1.0\r\n";
		$header .= "Host: $pp_domain\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ($pp_domain, 80, $errno, $errstr, 30);*/
		
		
		$verify_url = "https://ipnpb.paypal.com/cgi-bin/webscr";
		//$verify_url = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
		
		$raw_post_data = file_get_contents('php://input');
		
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
			$keyval = explode('=', $keyval);
			if (count($keyval) == 2) {
				// Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
				if ($keyval[0] === 'payment_date') {
					if (substr_count($keyval[1], '+') === 1) {
						$keyval[1] = str_replace('+', '%2B', $keyval[1]);
					}
				}
				$myPost[$keyval[0]] = urldecode($keyval[1]);
			}
		}
		
		
		// Build the body of the verification post request, adding the _notify-validate command.
		$req = 'cmd=_notify-validate';
		$get_magic_quotes_exists = false;
		if (function_exists('get_magic_quotes_gpc')) {
			$get_magic_quotes_exists = true;
		}
		foreach ($myPost as $key => $value) {
			if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
				$value = urlencode(stripslashes($value));
			} else {
				$value = urlencode($value);
			}
		
		
			$req .= "&$key=$value";
		}
		// Post the data back to PayPal, using curl. Throw exceptions if errors occur.
		
		
		$ch = curl_init($verify_url);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSLVERSION, 6);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		// This is often required if the server is missing a global cert bundle, or is using an outdated one.
		curl_setopt($ch, CURLOPT_CAINFO, LIB_DIR_PATH.'paypal-cert/cacert.pem');
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		$res = curl_exec($ch);
		
		if ( ! ($res)) {
			$errno = curl_errno($ch);
			$errstr = curl_error($ch);
			curl_close($ch);
		
			$this->log_trans("cURL error: [$errno] $errstr");
			die;
		}
		$info = curl_getinfo($ch);
		
		$http_code = $info['http_code'];
		if ($http_code != 200) {
			$this->log_trans("PayPal responded with http code $http_code");
			die;
		}
		curl_close($ch);
			
			
		// Assign posted variables to local variables
		$item_name = $this->read_post_param('item_name');
		$order_id = $this->read_post_param('item_number');
		$payment_status = $this->read_post_param('payment_status');
		$payment_amount = $this->read_post_param('mc_gross');
		$payment_currency =$this->read_post_param('mc_currency');
		$txn_id = $this->read_post_param('txn_id');
		$receiver_email = $this->read_post_param('business');
		$payer_email = $this->read_post_param('payer_email');
		$txn_type = $this->read_post_param('txn_type');
		$pending_reason = $this->read_post_param('pending_reason');
		$payment_type = $this->read_post_param('payment_type');
		$uid =$this->read_post_param('custom');
		$fee=$this->read_post_param('payment_fee');
			
		$db= DBLayer::get_instance();
		
		$uname=$this->get_user_name($uid);
		$admin_email=Settings::get_instance()->read('general_notification_email');
		$paypal_currency=Settings::get_instance()->read('paypal_currency');
		
		
		if (!$info)
		{
			// HTTP error
			$this->log_trans("HTTP Error, can't connect to Paypal");
			die;
		}
		else
		{
			$ret = "";
			//fputs ($fp, $header . $req);
			//while (!feof($fp)) $ret = fgets ($fp, 1024);
			//fclose ($fp);
		
			/*if (strcmp ($ret, "VERIFIED") == 0)
			{*/
				// check that receiver_email is your Primary PayPal email
				$paypal_email=Settings::get_instance()->read('paypal_email');
				if(strcasecmp($receiver_email,$paypal_email) !=0)
				{
					$this->log_trans("Wrong Receiver Email - $item_name");
					die;
				}
		
				// check that txn_id has not been previously processed
				$sql = "SELECT txnid FROM ".TABLE_PREFIX."paypal_ipn WHERE txnid = '$txn_id' AND result = '1'";
				$res1=$db->execute_query($sql);
				$val=$res1->fetch_assoc();
				if($val['txnid']!="")
				{
					// Entry present
					$this->log_trans("Invalid/Duplicate Transaction - $txn_id");
					die;
				}
				
				$sql = "SELECT * FROM ".TABLE_PREFIX."order WHERE id = '$order_id' AND user_id = '$uid'";
				$res1=$db->execute_query($sql);
				$val=$res1->fetch_assoc();
				
				$min_transaction_amount=$val['grand_cost'];
		
				if ($payment_amount < $min_transaction_amount)
				{
					$this->log_trans("Amount Less than Order Amount - Received: ".$payment_amount.$payment_currency."; Order Amount: ".$min_transaction_amount.$paypal_currency);
					die;
				}
		
				if ($payment_currency != $paypal_currency)
				{
					$this->log_trans("Wrong Currency - Received: $payment_currency; Expected: $paypal_currency");
					die;
				}
		
		
				// check the payment_status is Completed
				if ($payment_status != "Completed")
				{
					$this->log_trans("Incomplete Payment - Payment Status: $payment_status");
					die;
				}
				$this->log_trans("Success");
			/*}
			else
			{
				$this->log_trans("Invalid Transaction - $ret");
				die;
			}*/
		}
	}
	
	
	function log_trans($ecode)
	{
		$item_name = $this->read_post_param('item_name');
		$order_id = $this->read_post_param('item_number');
		$payment_status = $this->read_post_param('payment_status');
		$payment_amount = $this->read_post_param('mc_gross');
		$payment_currency =$this->read_post_param('mc_currency');
		$txn_id = $this->read_post_param('txn_id');
		$receiver_email = $this->read_post_param('business');
		$payer_email = $this->read_post_param('payer_email');
		$txn_type = $this->read_post_param('txn_type');
		$pending_reason = $this->read_post_param('pending_reason');
		$payment_type = $this->read_post_param('payment_type');
		$uid =$this->read_post_param('custom');
		$fee=$this->read_post_param('payment_fee');
	
			
		$t=time();
		$result = ($ecode=="Success"?1:0);
		$db= DBLayer::get_instance();
			
		$admin_email=Settings::get_instance()->read('general_notification_email');
	
		if($ecode=="Success")
		{	
				
			$uname=$this->get_user_name($uid);
			$email=$this->get_user_email($uid);
				
			$query1="select sub,body from ".TABLE_PREFIX."emailtemplates where id=6";// to user.. Order Payment Processed
			$res1=$db->execute_query($query1);
			$result1=$res1->fetch_assoc();
			$subject=$result1['sub'];
			$message=$result1['body'];
				
			$order_url=$this->make_url('order/details/'.$order_id);
			
			$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
			$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
			
			$message=str_replace("{NAME}",$uname,$message);
			$message=str_replace("{AMOUNT}",$this->get_money_format($payment_amount),$message);
			$message=str_replace("{PAYMENT_MODE}",$this->get_label('paypal'),$message);
			$message=str_replace("{TRANSACTION_ID}",$txn_id,$message);
			$message=str_replace("{ORDERURL}",$order_url,$message);
				
			UtilityHelper::send_mail($email,$subject,nl2br($message));
			
			
			$db->execute_query("BEGIN");
			$failed=0;

			if($db->execute_query("UPDATE ".TABLE_PREFIX."order SET payment_method=?,payment_date=?,status=? WHERE id=? and user_id=?",array(1,$t,2,$order_id,$uid)))
			{
				$query="INSERT INTO ".TABLE_PREFIX."payment_summary (uid,order_id,amount,payment_type,received_date,txn_id,payment_status)
					values(?,?,?,?,?,?,?)";
				$value=$db->execute_query($query,array($uid,$order_id,$payment_amount,1,$t,$txn_id,1));
					
				if($value->error=="")
				{
					
					$id=$value->last_id;
					$query1="INSERT INTO ".TABLE_PREFIX."paypal_ipn
						(payment_id,txnid,userid,result,resultdetails,amount,fee,currency,payeremail,receiveremail,paymenttype,status,pendingreason,receivedate)
						values	(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$value1=$db->execute_query($query1,array($id,$txn_id,$uid,$result,$ecode,$payment_amount,$fee,$payment_currency,$payer_email,
							$receiver_email,$txn_type,$payment_status,$pending_reason,$t));
						
					if($value1->error!="")
					{
						$failed=1;
					}
					
					$res0=$db->execute_query("select pro_id,quantity from ".TABLE_PREFIX."order_items where order_id=$order_id");
					while($row0=$res0->fetch_assoc())
					{
						if($row0['pro_id'] !="" && $row0['quantity'] !="")
						{
							
							$currentstock=$db->read_single_column("select prod_stock from ".TABLE_PREFIX."product where id=?",array($row0['pro_id']));
							$newstock=$currentstock-$row0['quantity'];
							if($newstock < 0)
							$newstock=0;
							
							
							
							if(!$db->execute_query("UPDATE ".TABLE_PREFIX."product SET prod_stock=? WHERE id=?",array($newstock,$row0['pro_id'])))
							$failed=1;
						}
					}
						
						
				}
				else
				{
					$failed=1;
				}
					
			}
			else
			{
				$failed=1;
			}
				
			$dbstatusmsg_admin='';
			if($failed==0)
			{
				$db->execute_query("COMMIT");
	
				$dbstatusmsg_admin='The database entries related to the payment were successfully captured.';
	
			}
			if($failed==1)
			{
				$db->execute_query("ROLLBACK");
				$dbstatusmsg_admin='The database entries related to the payment could not be added. Please do it manually';
			}
			
			$query1="select sub,body from ".TABLE_PREFIX."emailtemplates where id=13";// to admin.. Order Payment Processed
			$res1=$db->execute_query($query1);
			$result1=$res1->fetch_assoc();
			$subject=$result1['sub'];
			$message=$result1['body'];
			
			$order_url=$this->make_base_url('sales/details/'.$order_id,ADMIN_DIR);
				
			$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
			$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
				
			$message=str_replace("{NAME}",$uname,$message);
			$message=str_replace("{PAYER_EMAIL}",$payer_email,$message);
			$message=str_replace("{AMOUNT}",$this->get_money_format($payment_amount),$message);
			$message=str_replace("{PAYMENT_MODE}",$this->get_label('paypal'),$message);
			$message=str_replace("{TRANSACTION_ID}",$txn_id,$message);
			$message=str_replace("{ECODE}",$ecode,$message);
			$message=str_replace("{DBENTRY}",$dbstatusmsg_admin,$message);
			$message=str_replace("{ORDERURL}",$order_url,$message);
			
			UtilityHelper::send_mail($admin_email,$subject,nl2br($message));
				
		}
		else // all paypal failure cases
		{
				
			if($uid !="")
			{
					
				$uname=$this->get_user_name($uid);
				$email=$this->get_user_email($uid);
	
				$query1="select sub,body from ".TABLE_PREFIX."emailtemplates where id=7";// to user.. Payment Failed
				$res1=$db->execute_query($query1);
				$result1=$res1->fetch_assoc();
				$subject=$result1['sub'];
				$message=$result1['body'];
	
				$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
				$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
	
				$message=str_replace("{NAME}",$uname,$message);
				$message=str_replace("{PAYMENT_MODE}",$this->get_label('paypal'),$message);
				$message=str_replace("{AMOUNT}",$this->get_money_format($payment_amount),$message);
	
				UtilityHelper::send_mail($email,$subject,nl2br($message));
				
				
	
				$query1="select sub,body from ".TABLE_PREFIX."emailtemplates where id=14";// to admin.. Payment Failed
				$res1=$db->execute_query($query1);
				$result1=$res1->fetch_assoc();
				$subject=$result1['sub'];
				$message=$result1['body'];
				
				$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
				$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
				
				$message=str_replace("{NAME}",$uname,$message);
				$message=str_replace("{PAYER_EMAIL}",$payer_email,$message);
				$message=str_replace("{PAYMENT_MODE}",$this->get_label('paypal'),$message);
				$message=str_replace("{AMOUNT}",$this->get_money_format($payment_amount),$message);
				$message=str_replace("{ECODE}",$ecode,$message);
					
				UtilityHelper::send_mail($admin_email,$subject,nl2br($message));
	
	
			}
		}
	}
	
	
	function array2str($kvsep, $entrysep, $a)
	{
		$str = "";
		if(is_array($a))
		{
			foreach ($a as $k=>$v)
			{
				$str .= "{$k}{$kvsep}{$v}{$entrysep}";
			}
		}
		return $str;
	}

		
	function paypal_success_action()
	{
		/*if(!$_POST)
		{
			$this->flash($this->get_message('invalid payment'), BASE,0);
			exit;
		}
		$item_name = $this->read_post_param('item_name');
		$order_id= $this->read_post_param('item_number');
		$payment_status = $this->read_post_param('payment_status');
		$payment_amount = $this->read_post_param('mc_gross');
		$payment_currency =$this->read_post_param('mc_currency');
		$txn_id = $this->read_post_param('txn_id');
		$receiver_email = $this->read_post_param('business');
		$payer_email = $this->read_post_param('payer_email');
		$txn_type = $this->read_post_param('txn_type');
		$pending_reason = $this->read_post_param('pending_reason');
		$payment_type = $this->read_post_param('payment_type');
		$userid =$this-> read_post_param('custom');
		$fee=$this-> read_post_param('payment_fee');*/
		
		$item_name = "";
		$item_number = "";
		$payment_status = "";
		$payment_amount = '';
		$payment_currency ='';
		$txn_id = '';
		$receiver_email = '';
		$txn_type = '';
		$pending_reason = '';
		$payment_type = '';
		$userid ='';
		$fee='';
		$payer_email='';
		
		$pp_hostname = "www.paypal.com";
		//$pp_hostname = "www.sandbox.paypal.com";
		
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-synch';
		$tx_token = $_GET['tx'];
		$keyarray = array();
		if($tx_token!='')
		{
			$auth_token=Settings::get_instance()->read('paypal_auth_token');
		
			if($auth_token!='')
			{
				$req .= "&tx=$tx_token&at=$auth_token";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
				//set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
				//if your server does not bundled with default verisign certificates.
				curl_setopt($ch, CURLOPT_CAINFO, LIB_DIR_PATH.'paypal-cert/cacert.pem');
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $pp_hostname"));
				$res = curl_exec($ch);
				curl_close($ch);
				if($res){
					$lines = explode("\n", trim($res));
		
					if (strcmp ($lines[0], "SUCCESS") == 0) {
						for ($i = 1; $i < count($lines); $i++) {
							$temp = explode("=", $lines[$i],2);
							$keyarray[urldecode($temp[0])] = urldecode($temp[1]);
						}
					}
					else if (strcmp ($lines[0], "FAIL") == 0) {
						$this->set_notice("unable to verify paypal transaction");
					}
				}
			}
		}
		else
		{
			header("Location: ".$this->make_url("user/payments"));
			exit;
		}
		
		if(count($keyarray)>0)
		{
			$item_name = $keyarray['item_name'];
			$item_number = $keyarray['item_number'];
			$payment_status = $keyarray['payment_status'];
			$payment_amount = $keyarray['mc_gross'];
			$payment_currency =$keyarray['mc_currency'];
			$txn_id = $keyarray['txn_id'];
			$receiver_email = $keyarray['business'];
			$payer_email = $keyarray['payer_email'];
			$txn_type = $keyarray['txn_type'];
			
			if(isset($keyarray['pending_reason']))
				$pending_reason = $keyarray['pending_reason'];
			
			$payment_type = $keyarray['payment_type'];
			$userid =$keyarray['custom'];
			$fee=$keyarray['payment_fee'];
		}
		else if(isset($_GET['item_name']) && isset($_GET['item_number']) && isset($_GET['st']) && isset($_GET['amt']) && isset($_GET['cc']) && isset($_GET['cm']) && isset($_GET['tx']))
		{
			$item_name = $_GET['item_name'];
			$item_number = $_GET['item_number'];
			$payment_status = $_GET['st'];
			$payment_amount = $_GET['amt'];
			$payment_currency =$_GET['cc'];
			$userid =$_GET['cm'];
			$txn_id = $_GET['tx'];
		
		}

		$this->set_variable('item_name', $item_name);
		$this->set_variable('order_id',$order_id);
		$this->set_variable('payment_status', $payment_status);
		$this->set_variable('payment_amount', $payment_amount);
		$this->set_variable('payment_currency', $payment_currency);
		$this->set_variable('txn_id',$txn_id);
		$this->set_variable('receiver_email', $receiver_email);
		$this->set_variable('payer_email', $payer_email);
		$this->set_variable('userid', $userid);
		$this->set_variable('fee', $fee);
		$this->set_variable('pending_reason', $pending_reason);

	}


	
	function cancel_action()
	{
		$this->flash($this->get_message('paypal payment cancel'), BASE);
		die;
	}
	
	function details_action()
	{
		$this->set_title($this->get_label('payment details'));
		
		$paymentid=$this->read_page_param(1);
		$uid=$this->read_cookie_param(COOKIE_LOGINID);
	
		
		if(!$this->get_payment_exists($paymentid,$uid))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('user/payments'),0);
			exit;
		}
		
		
		$db= DBLayer::get_instance();
		$query = "select a.*,b.order_id from ".TABLE_PREFIX."paypal_ipn a JOIN ".TABLE_PREFIX."payment_summary b ON a.payment_id=b.id where a.payment_id=? ORDER BY a.id desc";
		$res=$db->execute_query($query,array($paymentid));
		$this->set_result('res', $res);
			
		
	}

};
?>