<?php
ob_start();
session_start();
include_once 'dbconfig.php';
include_once 'payconfig.php';
require_once 'vendor/autoload.php';

$cart_unique_id = '';
$flag = false;
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
$stmt->close();
$stmt = null;

/* if nothing is purchased then redirect to home page */
if(empty($amount))
{
    header("Location:index.php");
}

if(!empty($_POST['stripeToken']))
{
     
    // Set API key 
    \Stripe\Stripe::setApiKey(STRIPE_API_KEY);
    
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
    
    
    if($charge->status == "succeeded")
    {
        //Create order info
        $sql_order_insert = "INSERT INTO tblorders (order_unique_id, order_amt, order_currency, order_cust_id, order_time, paid_status) ";
        $sql_order_insert.=" VALUES(?,?,?,?,?,?) ";
        
        try
        {
            $stmtorder=$mysqli->prepare($sql_order_insert);
            $stmtorder->bind_param('sdssss', $order_unique_id, $order_amt, $order_currency, $order_cust_id, $order_time, $paid_status);
        
            $order_unique_id = $_SESSION['unique_id'];
            $order_amt = ($charge->amount)/100;
            $order_currency = strtoupper($charge->currency);
            $order_cust_id = $charge->customer;
            $order_time = date('Y-m-d H:i:s', time());
            $paid_status = '1';
            $stmtorder->execute();
            //Get the inserted order id
            $order_create_id = $stmtorder->insert_id;
            
            $stmtorder->close();
            $stmtorder = null;
            
        } catch(Exception $ex) {
            echo $mysqli->error;
            echo $ex->getMessage();
        }
        
        
        //Create payment info
        $sql_payment_insert = "INSERT INTO tblpayments (txn_id, order_id, payment_gross, currency_code, payer_id, payment_status) VALUES(?,?,?,?,?,?)";
        $stmtpayment = $mysqli->prepare($sql_payment_insert);
        $stmtpayment->bind_param('sidsss', $txn_id, $order_id, $payment, $currency, $payer_id, $payment_status);
        
        $txn_id = $charge->id;
        $order_id = $order_create_id;
        $payment = ($charge->amount)/100;
        $currency = strtoupper($charge->currency);
        $payer_id = $charge->customer;
        $payment_status = $charge->status;
        
        $stmtpayment->execute();
        
        
        $stmtpayment->close();
        $stmtpayment = null;
        $mysqli->close();		
		
        unset($_SESSION['unique_id']);
		session_regenerate_id();
		$_SESSION['flash'] = 'Thank you. Your order has been placed successfully.';
        
        $flag = true;
        
        $trans_id = $charge->id;
        $payment_gross = ($charge->amount)/100;
        $payment_status = $charge->status;
        
        
    }
    
    
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Stripe payment processing page</title>
        <link rel="stylesheet" href="css/custom.css">
    </head>
    <body>
        <?php
        if($flag)
        {
        ?>
            <h3>Payment is successful.Following is your payment info:</h3>
            <div class="status">
                <p>Transaction id:<?php echo $trans_id; ?></p>
                <p>Payment amount:<?php echo $payment_gross.$currency; ?></p>
                <p>Payment status:<?php echo $payment_status; ?></p>
            </div>
        <?php
        }
        ?>
    </body>
</html>
<script>
    function Redirect() 
    {  
        window.location="index.php"; 
    } 
    //document.write("You will be redirected to a new page in 5 seconds"); 
    setTimeout('Redirect()', 5000);
</script>