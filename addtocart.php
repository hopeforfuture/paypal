<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Kolkata');
include_once 'dbconfig.php';
$getdata = $_GET;
$sessdata = $_SESSION;
if(empty($getdata))
{
	header("Location:index.php");
}
if(!array_key_exists('unique_id', $sessdata))
{
	/* Create unique ID for user */
	$_SESSION['unique_id'] = time()."_".rand(10000,10000000);
}
if(array_key_exists('id', $getdata))
{
	$product_id = (int)$_GET['id'];
	$quantity = 1;
	$unique_id = $_SESSION['unique_id'];
	
	$sql_product_info = "SELECT price FROM products WHERE id=?";
	$stmt = $mysqli->prepare($sql_product_info);
	$stmt->bind_param('i', $id);
	$id = $product_id;
	$stmt->execute();
	$stmt->bind_result($price);
	$stmt->fetch();
	
	$item_price = $price;
	$created = time();
	$stmt->close();
	$stmt = null;
	
	/* Insert Into Cart Table */
	$sql_insert_cart = "INSERT INTO tblcart (unique_id, item_id, item_quantity, item_price, created) VALUES(?,?,?,?,?)";
	$stmt = $mysqli->prepare($sql_insert_cart);
	$stmt->bind_param('siiii', $cart_unique_id, $item_id, $item_quantity, $cost, $create_time);
	$cart_unique_id = $unique_id;
	$item_id = $product_id;
	$item_quantity = $quantity;
	$cost = $item_price;
	$create_time = $created;
	$stmt->execute();
	$stmt->close();
	$mysqli->close();
	header("Location:view_cart.php?msg=a");
	
}
?>
