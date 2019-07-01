<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Kolkata');
include_once 'dbconfig.php';
include_once 'PaypalExpress.class.php';
$getdata = $_GET;
$sum = 0;
if(!empty($getdata['paymentID']) && !empty($getdata['token']) && !empty($getdata['payerID']))
{
	// Get payment info from URL
    $paymentID = $getdata['paymentID'];
    $token = $getdata['token'];
    $payerID = $getdata['payerID'];
	
	$paypal = new PaypalExpress;
	
	// Validate transaction via PayPal API
    $paymentCheck = $paypal->validate($paymentID, $token, $payerID);
	
	if(!empty($paymentCheck))
	{
		if($paymentCheck->state == 'approved')
		{
			// Get the transaction data
			$id = $paymentCheck->id;
			$state = $paymentCheck->state;
			$payerFirstName = $paymentCheck->payer->payer_info->first_name;
			$payerLastName = $paymentCheck->payer->payer_info->last_name;
			$payerName = $payerFirstName.' '.$payerLastName;
			$payerEmail = $paymentCheck->payer->payer_info->email;
			$payerID = $paymentCheck->payer->payer_info->payer_id;
			$payerCountryCode = $paymentCheck->payer->payer_info->country_code;
			$paidAmount = $paymentCheck->transactions[0]->amount->details->subtotal;
			$currency = $paymentCheck->transactions[0]->amount->currency;
			
			//Find total amount for an order
			$sql_order_cost = "SELECT item_price FROM tblcart WHERE unique_id=?";
			$stmt = $mysqli->prepare($sql_order_cost);
			$stmt->bind_param('s', $unique_id);
			$unique_id = $_SESSION['unique_id'];
			$stmt->execute();
			$stmt->bind_result($price);
			while($stmt->fetch())
			{
				$sum+=$price;
			}
			$stmt->close();
			$stmt = null;
			
			if($sum == $paidAmount)
			{
				$sql_order_insert = "INSERT INTO tblorders (order_unique_id, order_amt, order_currency, order_cust_id, order_time, paid_status) ";
				$sql_order_insert.="VALUES(?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($sql_order_insert);
				$stmt->bind_param('sdsiss', $order_unique_id, $order_amt, $order_currency, $cust_id, $time, $paid);
				$order_unique_id = $_SESSION['unique_id'];
				$order_amt = $paidAmount;
				$order_currency = $currency;
				$cust_id = $payerID;
				$time = date('Y-m-d H:i:s', time());
				$paid = '1';
				$stmt->execute();
				$order_id = $stmt->insert_id;
				$stmt->close();
				$stmt = null;
				
				
				$sql_payment_insert = "INSERT INTO tblpayments (txn_id, order_id, payment_gross, currency_code, payer_id, payer_name, payer_email, payer_country, payment_status) VALUES(?,?,?,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($sql_payment_insert);
				$stmt->bind_param('sidssssss', $txn, $order_id_pay, $gross, $currencyname, $payer, $fullname, $email, $country, $paystatus);
				$txn = $id;
				$order_id_pay = $order_id;
				$gross = $paidAmount;
				$currencyname = $currency;
				$payer = $payerID;
				$fullname = ucwords($payerName);
				$email = $payerEmail;
				$country = $payerCountryCode;
				$paystatus = $state;
				$stmt->execute();
				$stmt->close();
				$mysqli->close();
				$stmt = null;
				
				unset($_SESSION['unique_id']);
				session_regenerate_id();
				$_SESSION['flash'] = 'Thank you. Your order has been placed successfully.';
				header("Location:index.php");
				
			}
		}
	}
}
?>