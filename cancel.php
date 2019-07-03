<!DOCTYPE html>
<html>
<head>
	<title>Payment Cancel Page</title>
</head>
<body>
	<div class="container">
		<div class="status">
			<h1 class="error">Your PayPal Transaction has been Cancelled</h1>
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