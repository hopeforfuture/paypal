<?php
ob_start();
session_start();
include_once 'dbconfig.php';
include_once 'PaypalExpress.class.php';
$paypal = new PaypalExpress;
$dir = "uploads/";
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
$sql_cart_products = "SELECT products.name, products.details, products.product_image, tblcart.item_id, tblcart.item_quantity, tblcart.item_price ";
$sql_cart_products.="FROM products JOIN tblcart ON tblcart.item_id = products.id WHERE tblcart.unique_id=? ORDER BY tblcart.id DESC";
$stmt = $mysqli->prepare($sql_cart_products);
$stmt->bind_param('s', $unique_id);
$unique_id = $cart_unique_id;
$stmt->execute();
$stmt->bind_result($name, $details, $image, $product_id, $quantity, $price);

while($stmt->fetch())
{
	$cartitems[] = array(
		'name'=>$name,
		'details'=>$details,
		'thumb'=>$image,
		'product_id'=>$product_id,
		'quantity'=>$quantity,
		'price'=>$price
	);
}

$getdata = $_GET;
$msg =   '';

if(array_key_exists('msg', $getdata))
{
	switch($getdata['msg'])
	{
		case 'a':
			$msg = 'Item added to cart successfully.';
		break;
		
		case 'r':
			$msg = 'Item removed from cart successfully.';
		break;
	}
}



?>
<!DOCTYPE html>
<html>
	<head>
		<title>List of Items in Cart</title>
		<script language="Javascript" src="js/jquery.js"></script>
	</head>
	<body>
		<h3 align="center">List of Items in Cart</h3>
		<div align="center">
			<a href="index.php">[Continue Shopping]</a>
		</div>
		<table align="center" border="1">
			
			<thead>
				<?php
				if(!empty($msg))
				{
					echo "<tr><td colspan='5' align='center' style='color:red;font-weight:bold;'>".$msg."</td></tr>";
				}
				?>
				<tr>
					<th>SI No</th>
					<th>Item Name</th>
					<th>Item Price(USD)</th>
					<th>Item Image</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(empty($cartitems))
				{
					echo "<tr><td colspan='5' align='center' style='color:red;font-weight:bold;'>No data found.</td></tr>";
				}
				else
				{
					foreach($cartitems as $cart)
					{
						$sum+=$cart['price'];
					?>
					<tr>
						<td><?php echo $counter; ?></td>
						<td><?php echo ucwords($cart['name']); ?></td>
						<td><?php echo number_format($cart['price'], 2); ?></td>
						<td>
							<img src="<?php echo $dir.$cart['thumb']; ?>" width="80" height="60" />
						</td>
						<td>
							<a onclick="Javascript:return confirm('Confirm Delete?');" href="remove_item_cart.php?id=<?php echo $cart['product_id']; ?>">[REMOVE]</a>
						</td>
					</tr>	
					<?php
						$counter++;
					}
					?>
					
					<tr>
						<td colspan='5' align='right'>Total Cost: <?php echo "USD.".number_format($sum, 2); ?></td>
					</tr>
					
					<?php
				}
					?>
			</tbody>
		</table>
		<?php
		if($sum > 0)
		{
		?>
		<div id="paypal-button"></div>
		<div>
			<a href="Javascript:void(0);" id="pay-standard"><img src="images/btn_buynow_LG.gif"></a>
		</div>
		<?php } ?>
	</body>
</html>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script language="javascript">
	paypal.Button.render({
    // Configure environment
    env: '<?php echo $paypal->paypalEnv; ?>',
    client: {
        sandbox: '<?php echo $paypal->paypalClientID; ?>',
        production: '<?php echo $paypal->paypalClientID; ?>'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
        size: 'small',
        color: 'gold',
        shape: 'pill',
    },
    // Set up a payment
    payment: function (data, actions) {
        return actions.payment.create({
            transactions: [{
                amount: {
                    total: '<?php echo $sum; ?>',
                    currency: 'USD'
                }
            }]
      });
    },
    // Execute the payment
    onAuthorize: function (data, actions) {
        return actions.payment.execute()
        .then(function () {
            // Show a confirmation message to the buyer
            //window.alert('Thank you for your purchase!');
            
            // Redirect to the payment process page
            window.location = "process.php?paymentID="+data.paymentID+"&token="+data.paymentToken+"&payerID="+data.payerID;
        });
    }
}, '#paypal-button');


$("document").ready(function(){
	$("body").on("click", "#pay-standard", function(){
		window.location.href='paypalform.php';
	});
});

</script>