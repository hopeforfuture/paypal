<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Kolkata');
include_once 'payconfig.php';
include_once 'dbconfig.php';
$sessdata = $_SESSION;
if(array_key_exists('unique_id', $sessdata))
{
	$cart_unique_id = $_SESSION['unique_id'];
}
else
{
	$cart_unique_id = '';
}
 
/* 
 * Read POST data 
 * reading posted data directly from $_POST causes serialization 
 * issues with array data in POST. 
 * Reading raw POST data from input stream instead. 
 */         
$raw_post_data = file_get_contents('php://input'); 
$raw_post_array = explode('&', $raw_post_data); 
if(empty($raw_post_array))
{
	header("Location:index.php");
}
$myPost = array(); 
foreach ($raw_post_array as $keyval) { 
    $keyval = explode ('=', $keyval); 
    if (count($keyval) == 2) 
        $myPost[$keyval[0]] = urldecode($keyval[1]); 
} 
 
// Read the post from PayPal system and add 'cmd' 
$req = 'cmd=_notify-validate'; 
if(function_exists('get_magic_quotes_gpc')) { 
    $get_magic_quotes_exists = true; 
} 
foreach ($myPost as $key => $value) { 
    if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
        $value = urlencode(stripslashes($value)); 
    } else { 
        $value = urlencode($value); 
    } 
    $req .= "&$key=$value"; 
} 
 
/* 
 * Post IPN data back to PayPal to validate the IPN data is genuine 
 * Without this step anyone can fake IPN data 
 */ 
$paypalURL = PAYPAL_URL; 
$ch = curl_init($paypalURL); 
if ($ch == FALSE) { 
    return FALSE; 
} 
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); 
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $req); 
curl_setopt($ch, CURLOPT_SSLVERSION, 6); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1); 
 
// Set TCP timeout to 30 seconds 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name')); 
$res = curl_exec($ch); 
 
/* 
 * Inspect IPN validation result and act accordingly 
 * Split response headers and payload, a better way for strcmp 
 */  
$tokens = explode("\r\n\r\n", trim($res)); 
$res = trim(end($tokens)); 
if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) { 
     
    // Retrieve transaction info from PayPal 
    $item_number    = $_POST['item_number']; 
    $txn_id         = $_POST['txn_id']; 
    $payment_gross     = $_POST['mc_gross']; 
    $currency_code     = $_POST['mc_currency']; 
    $payment_status = $_POST['payment_status']; 
     
    /* Create order */
	$sql_order_insert = "INSERT INTO tblorders (order_unique_id, order_amt, order_currency, order_time, paid_status)";
	$sql_order_insert.=" VALUES(?,?,?,?,?) ";
	$stmt = $mysqli->prepare($sql_order_insert);
	$stmt->bind_param('sdsss', $unique_id, $amt, $currency, $time, $paid);
	$unique_id = $cart_unique_id;
	$amt = $payment_gross;
	$currency = $currency_code;
	$time = date('Y-m-d H:i:s', time());
	$paid_status = '1';
	$stmt->execute();
	$order_insert_id = $stmt->insert_id;
	$stmt->close();
	$stmt = null;
	
	/* Create Payment */
	$sql_payment_insert = "INSERT INTO tblpayments (txn_id, order_id, payment_gross, currency_code, payment_status) VALUES(?,?,?,?,?)";
	$stmt = $mysqli->prepare($sql_payment_insert);
	$stmt->bind_param('sidss', $transaction_id, $order_id, $order_amt, $cc, $status);
	$transaction_id = $txn_id;
	$order_id = $order_insert_id;
	$order_amt = $payment_gross;
	$cc = $currency_code;
	$status = $res;
	$stmt->execute();
	$stmt->close();
	$mysqli->close();
} 
?>