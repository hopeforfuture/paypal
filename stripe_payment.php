<!DOCTYPE html>
<html>
    <head>
        <title>Stripe Payment Page</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
      <div class="container">
        <form action="stripepaymentprocess.php" method="post" id="payment-form">
            <div class="form-row">
                
                <input type="text" class="form-control mb-3 StripeElement StripeElement--empty" name="first_name" placeholder="First Name" />
                <input type="text" class="form-control mb-3 StripeElement StripeElement--empty" name="last_name" placeholder="Last Name" />
                <input type="email" class="form-control mb-3 StripeElement StripeElement--empty" name="email" placeholder="Email Address" />
                
                <div id="card-element" class="form-control">
                  <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
            </div>

            <button>Submit Payment</button>
        </form>
      </div>
        <script src="https://js.stripe.com/v3/"></script>
        <script type="text/javascript" src="js/charge.js"></script>
    </body>
</html>