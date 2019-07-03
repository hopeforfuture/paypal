<?php
ob_start();
session_start();
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

$counter = 1;
$cartitems = array();
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
	$cartitems[] = array(
		'name'=>$name,
		'quantity'=>$quantity,
		'price'=>$price
	);
}

$stmt->close();
$mysqli->close();

if((int)$sum == 0)
{
	header("Location:index.php");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>PAYPAL Form Processing</title>
		<script language="javascript" src="js/jquery.js"></script>
	</head>
	<form method="post" action="<?php echo PAYPAL_URL; ?>" id="payform">
		<!-- Identify your business so that you can collect the payments. -->
		<input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">
		
		<!-- Specify a Buy Now button. -->
		<input type="hidden" name="cmd" value="_cart">
		
		<?php
		  foreach($cartitems as $cart)
		  {
		?>
		<input type="hidden" name="item_name_<?php echo $counter; ?>" value="<?php echo $cart['name']; ?>">
		<input type="hidden" name="quantity_<?php echo $counter; ?>" value="<?php echo $cart['quantity']; ?>">
		<input type="hidden" name="amount_<?php echo $counter; ?>" value="<?php echo $cart['price']; ?>">
		<?php
			 $counter++;
		  }
		?>
		
		<input type="hidden" name="custom" value="1" />
		<input type="hidden" name="upload" value="1" />
		
		<!--<input type="hidden" name="item_name" value="<?php echo "Shopping Items"; ?>">
		<input type="hidden" name="item_number" value="1">
		<input type="hidden" name="amount" value="<?php echo $sum; ?>">-->
		<input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">
		<!-- Specify URLs -->
		<input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
		<!--<input type="hidden" name="notify_url" value="<?php echo PAYPAL_NOTIFY_URL; ?>">-->
		<input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">
	</form>
</html>
<script>
$(document).ready(function(){
	$("#payform").submit();
});
</script>