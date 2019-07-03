<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Kolkata');
include_once 'dbconfig.php';
include_once 'payconfig.php';

$sessdata = $_SESSION;
if(array_key_exists('unique_id', $sessdata))
{
	$cart_unique_id = $_SESSION['unique_id'];
}
else
{
	$cart_unique_id = '';
}
$getinfo = $_GET;
$flag = false;
if(empty($getinfo))
{
	header("Location:index.php");
}
$payment_id = '';
$counter = 1;
//$cartitems = array();
$sum = 0;
$sql_cart_products = "SELECT products.name,  tblcart.item_quantity, tblcart.item_price ";
$sql_cart_products.="FROM products JOIN tblcart ON tblcart.item_id = products.id WHERE tblcart.unique_id=? ORDER BY tblcart.id DESC";
$stmt = $mysqli->prepare($sql_cart_products);
$stmt->bind_param('s', $unique_id);
$unique_id = $cart_unique_id;
$stmt->execute();
$stmt->bind_result($name, $quantity, $price);

while($stmt->fetch())
{
	$sum = $sum + $quantity*$price;
}
$stmt->close();


// If transaction data is available in the URL 
if(!empty($getinfo['tx']) && !empty($getinfo['amt']) && !empty($getinfo['cc']) && !empty($getinfo['st']))
{ 
    // Get transaction information from URL  
    $txn_id = $getinfo['tx']; 
    $payment_gross = $getinfo['amt']; 
    $currency_code = $getinfo['cc']; 
    $payment_status = $getinfo['st'];
	
	if($payment_gross == $sum)
	{
		
		/* Create order */
		$sql_order_insert = "INSERT INTO tblorders (order_unique_id, order_amt, order_currency, order_time, paid_status)";
		$sql_order_insert.=" VALUES(?,?,?,?,?) ";
		$stmt = $mysqli->prepare($sql_order_insert);
		$stmt->bind_param('sdsss', $unique_id, $amt, $currency, $time, $paid);
		$unique_id = $cart_unique_id;
		$amt = $payment_gross;
		$currency = $currency_code;
		$time = date('Y-m-d H:i:s', time());
		$paid = '1';
		/*$stmt->bind_param('sdsss', $cart_unique_id, $payment_gross, $currency_code, date('Y-m-d H:i:s', time()), '1');*/
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
		$status = $payment_status;
		$stmt->execute();
		$payment_id = $stmt->insert_id;
		$stmt->close();
		$mysqli->close();
		
		$flag = true;
		unset($_SESSION['unique_id']);
		session_regenerate_id();
		$_SESSION['flash'] = 'Thank you. Your order has been placed successfully.';
	}

}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Payment Success Page</title>
		<script language="javascript" src="js/jquery.js"></script>
	</head>
	<body>
		<div>
			<div class="status">
        <?php if($flag){ ?>
            <h1 class="success">Your Payment has been Successful</h1>
			
            <h4>Payment Information</h4>
            <p><b>Reference Number:</b> <?php echo $payment_id; ?></p>
            <p><b>Transaction ID:</b> <?php echo $txn_id; ?></p>
            <p><b>Paid Amount:</b> <?php echo $payment_gross; ?></p>
            <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>
        <?php }else{ ?>
            <h1 class="error">Your Payment has Failed</h1>
        <?php } ?>
    </div>
    <a href="index.php" class="btn-link">Continue Shopping</a>
		</div>
	</body>
</html>
<script>
	function Redirect() 
    {  
        window.location="index.php"; 
    } 
    //document.write("You will be redirected to a new page in 10 seconds"); 
    setTimeout('Redirect()', 5000); 
</script>