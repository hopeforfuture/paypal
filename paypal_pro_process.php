<?php
ob_start();
session_start();
include_once 'payconfig.php';
include_once 'dbconfig.php';
$data = array();
// Function to convert NTP string to an array
function NVPToArray($NVPString)
{
    $proArray = array();
    while(strlen($NVPString))
    {
        // name
        $keypos= strpos($NVPString,'=');
        $keyval = substr($NVPString,0,$keypos);
        // value
        $valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
        $valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
        // decoding the respose
        $proArray[$keyval] = urldecode($valval);
        $NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
    }
    return $proArray;
}



if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Buyer information
    $name = $_POST['name_on_card'];
    $nameArr = explode(' ', $name);
    $firstName = !empty($nameArr[0])?$nameArr[0]:'';
    $lastName = !empty($nameArr[1])?$nameArr[1]:'';
    
    // Card details
    $creditCardNumber = trim(str_replace(" ","", $_POST['card_number']));
    $creditCardType =  $_POST['card_type'];
    $expMonth =  $_POST['expiry_month'];
    $expYear =  $_POST['expiry_year'];
    $cvv =  $_POST['cvv'];
	
	$price = 0;
	
	$sql_cart_item = "SELECT item_quantity, item_price FROM tblcart WHERE unique_id=?";
	$stmt = $mysqli->prepare($sql_cart_item);
	$stmt->bind_param('s', $unique_id);
	$unique_id = $_SESSION['unique_id'];
	$stmt->execute();
	$stmt->bind_result($quantity, $cost);
	
	while($stmt->fetch())
	{
		$price = $price + $quantity * $cost;
	}
	
	$stmt->close();
	$stmt = null;
	
	$request_params = array
                    (
                    'METHOD' => 'DoDirectPayment', 
                    'USER' => API_USERNAME, 
                    'PWD' => API_PASSWORD, 
                    'SIGNATURE' => API_SIGNATURE, 
                    'VERSION' => API_VERSION, 
                    'PAYMENTACTION' => 'Sale',                   
                    'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
                    'CREDITCARDTYPE' => $creditCardType, 
                    'ACCT' => $creditCardNumber,                        
                    'EXPDATE' => $expMonth.$expYear,           
                    'CVV2' => $cvv, 
                    'FIRSTNAME' => $firstName, 
                    'LASTNAME' => $lastName, 
                    'STREET' => '707 W. Bay Drive', 
                    'CITY' => 'Largo', 
                    'STATE' => 'FL',                     
                    'COUNTRYCODE' => 'US', 
                    'ZIP' => '33770', 
                    'AMT' => $price, 
                    'CURRENCYCODE' => 'USD', 
                    'DESC' => 'Testing Payments Pro'
                    );
					
					
	$nvp_string = '';
	foreach($request_params as $var=>$val)
	{
		$nvp_string .= '&'.$var.'='.urlencode($val);    
	}
	
	// Send NVP string to PayPal and store response
	$curl = curl_init();
    curl_setopt($curl, CURLOPT_VERBOSE, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_URL, API_ENDPOINT);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);
 
	$result = curl_exec($curl);     
	curl_close($curl);
	
	$paymentresponse = NVPToArray($result);
	
	if((strcmp($paymentresponse['ACK'], "Success") == 0) || (strcasecmp($paymentresponse['ACK'], "Success") == 0))
	{
		$sql_order_insert = "INSERT INTO tblorders (order_unique_id, order_amt, order_currency, order_time, paid_status) ";
		$sql_order_insert.=" VALUES(?,?,?,?,?) ";
		$stmt = $mysqli->prepare($sql_order_insert);
		$stmt->bind_param("sdsss",$unique, $amt, $cc, $time, $paid);
		$unique = $_SESSION['unique_id'];
		$amt = $paymentresponse['AMT'];
		$cc = $paymentresponse['CURRENCYCODE'];
		$time = date('Y-m-d H:i:s', time());
		$paid = '1';
		$stmt->execute();
		
		$sql_payments_insert = "INSERT INTO tblpayments (txn_id, order_id, payment_gross, currency_code, payment_status)";
		$sql_payments_insert.=" VALUES(?,?,?,?,?) ";
		$stmtpayment = $mysqli->prepare($sql_payments_insert);
		$stmtpayment->bind_param("sidss", $txn,$order,$gross,$currency,$status);
		$txn = $paymentresponse['TRANSACTIONID'];
		$order = $stmt->insert_id;
		$gross = $paymentresponse['AMT'];
		$currency = $paymentresponse['CURRENCYCODE'];
		$status = $paymentresponse['ACK'];
		$stmtpayment->execute();
		
		$data['status'] = 1;
		$data['orderID'] = $stmt->insert_id;
		$data['txn_id'] = $paymentresponse['TRANSACTIONID'];
		
		$stmt->close();
		$stmtpayment->close();
		$mysqli->close();
		
		unset($_SESSION['unique_id']);
		session_regenerate_id();
		$_SESSION['flash'] = 'Thank you. Your order has been placed successfully.';
		
	}
	else
	{
		$data['status'] = 0;
	}
	
	echo json_encode($data);
	die;
	//echo "<pre>";
	//print_r($paymentresponse);
	//echo "</pre>";
	//die;
	// Parse the API response
	//$nvp_response_array = parse_str($result);
	
}
?>