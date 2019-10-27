<?php
ob_start();
session_start();
include_once 'dbconfig.php';
$sql_products = "SELECT id, name, details, price, product_image FROM products";
$stmt = $mysqli->prepare($sql_products);
$stmt->execute();
$stmt->bind_result($product_id, $product_name, $product_details, $product_cost, $product_image);
$products = array();
$dir = "uploads/";
$count = 1;
while($stmt->fetch())
{
	$products[] = array(
		'product_id'=>$product_id,
		'product_name'=>$product_name,
		'product_details'=>$product_details,
		'product_cost'=>$product_cost,
		'product_image'=>$product_image
	);
}

$flash_msg = '';
$sessdata = $_SESSION;
if(array_key_exists('flash', $sessdata))
{
	$flash_msg = $_SESSION['flash'];
	unset($_SESSION['flash']);
}


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Paypal Integration in PHP</title>
        <link rel="stylesheet" href="css/custom.css">
		<script language="Javascript" src="js/jquery.js"></script>
	</head>
	<body>
		
		<div class="heading"><a href="view_cart.php">[VIEW CART]</a></div>
        <h3>List of Products</h3>
		<table class="content-table">
            <?php
            if(!empty($flash_msg))
            {
            ?>
                <h3 class="msg"><?php echo $flash_msg; ?></h3>
            <?php
            }
            ?>
			<thead>
				<tr>
					<th>SI NO</th>
					<th>Product Name</th>
					<th>Product Price(USD)</th>
					<th>Product Description</th>
					<th>Product Image</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(empty($products))
				{
					echo "<tr><td colspan='5' align='center' style='color:red; font-weight:bold;'>No data found.".'</td></tr>';
				}
				else
				{
					foreach($products as $product)
					{
					?>
						<tr>
							<td><?php echo $count; ?></td>
							<td><?php echo ucwords($product['product_name']); ?></td>
							<td><?php echo number_format($product['product_cost']); ?></td>
							<td><?php echo ucfirst($product['product_details']); ?></td>
							<td>
								<img src="<?php echo $dir.$product['product_image']; ?>" width="120" height="80" />
							</td>
							<td>
								<a href="addtocart.php?id=<?php echo $product['product_id']; ?>">[ADD TO CART]</a>
							</td>
						</tr>
					<?php
						$count++;
					}
				}
					
				?>
			</tbody>
		</table>
		
	</body>
</html>