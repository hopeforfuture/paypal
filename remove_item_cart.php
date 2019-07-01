<?php
ob_start();
session_start();
include_once 'dbconfig.php';
$getdata = $_GET;
if(empty($getdata))
{
	header("Location:index.php");
}
if(array_key_exists('id', $getdata))
{
	$id = (int)$getdata['id'];
	
	$sql_item_remove = "DELETE FROM tblcart WHERE item_id=? AND unique_id=?";
	$stmt = $mysqli->prepare($sql_item_remove);
	$stmt->bind_param('is', $product_id, $unique_id);
	$product_id = $id;
	$unique_id = $_SESSION['unique_id'];
	$stmt->execute();
	
	header("Location:view_cart.php?msg=r");
}
?>