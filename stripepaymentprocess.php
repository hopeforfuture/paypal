<?php
ob_start();
session_start();
include_once 'dbconfig.php';
include_once 'payconfig.php';
require_once 'vendor/autoload.php';

$cart_unique_id = '';
$sessdata = $_SESSION;
if(array_key_exists('unique_id', $sessdata))
{
	$cart_unique_id = $_SESSION['unique_id'];
}
$sql_cart_amt = "SELECT SUM(item_quantity*item_price) FROM tblcart WHERE unique_id=?";
$stmt = $mysqli->prepare($sql_cart_amt);
$stmt->bind_param('s', $unique_id);
$unique_id = $cart_unique_id;
$stmt->execute();
$stmt->bind_result($amount);
$stmt->fetch();

/* if nothing is purchased then redirect to home page */
if(empty($amount))
{
    header("Location:index.php");
}

if(!empty($_POST['stripeToken']))
{
     
    // Set API key 
    \Stripe\Stripe::setApiKey('sk_test_tgBGiijmsl5rd3LS6KzPK6t600KmG8B8L2');
    
    //Sanitize array
    $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
     
    $first_name = trim($post['first_name']);
    $last_name = trim($post['last_name']);
    $email = trim($post['email']);
    $token = trim($post['stripeToken']);
    
    //Create customer in stripe
    $customer = \Stripe\Customer::create(array(
            "email" => $email,
            "source" => $token
        )  
    );
    
    
    //Charge a customer
    $charge = \Stripe\Charge::create(array(
            "amount" => $amount*100,
            "currency" => "usd",
            "description" => "shopping",
            "customer" => $customer->id
        )  
    );
    
    echo "<pre>";
    print_r($charge);
    echo "</pre>";
    
    
}

?>