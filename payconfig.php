<?php 
/*PayPal configuration */
//define('PAYPAL_ID', 'developer.manojit@gmail.com'); 
define('PAYPAL_ID', 'manojit.smartwork@gmail.com'); 
define('PAYPAL_SANDBOX', TRUE); //TRUE or FALSE 

/* Paypal Pro Integration */
define('API_VERSION', '85.0');
define('API_ENDPOINT', (PAYPAL_SANDBOX == true) ? "https://api-3t.sandbox.paypal.com/nvp":"https://api-3t.paypal.com/nvp");
define('API_USERNAME', (PAYPAL_SANDBOX == true) ? "manojit.smartwork_api1.gmail.com":"");
define('API_PASSWORD', (PAYPAL_SANDBOX == true) ? "AKJL9KWB67JYAVX8":"");
define('API_SIGNATURE', (PAYPAL_SANDBOX == true) ? "A8iHridokODAOI7h2cIy.B4KWYROA3eQoCuuOoszBkYfF-BqEosK6JDq":"");
/* End */

/* Paypal Standard Integration */
define('PAYPAL_RETURN_URL', 'http://localhost/paypal/success.php'); 
define('PAYPAL_CANCEL_URL', 'http://localhost/paypal/cancel.php'); 
define('PAYPAL_NOTIFY_URL', 'http://localhost/paypal/ipn.php'); 
define('PAYPAL_CURRENCY', 'USD'); 
/* End */


// Change not required 
define('PAYPAL_URL', (PAYPAL_SANDBOX == true)?"https://www.sandbox.paypal.com/cgi-bin/webscr":"https://www.paypal.com/cgi-bin/webscr");