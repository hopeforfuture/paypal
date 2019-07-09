<div  class="container">
  
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Payment Details</h4>
		  <div id="paymentSection"></div>
        </div>
        <div class="modal-body">
		<form method="post" name="paymentForm" id="paymentForm">
		
		  <div class="form-group">
				<label for="card_number">Card Type</label>
				<select class="form-control" name="card_type" id="card_type">
					<option value="Visa">Visa</option>
					<option value="MasterCard">MasterCard</option>
					<option value="Discover">Discover</option>
				</select>
		   </div>
		
		   <div class="form-group">
				<label for="card_number">Card Number</label>
				<input type="text" class="form-control" id="card_number" name="card_number" maxlength="20" />
		   </div>
		   
		   <div class="form-group">
				<label for="card_number">Expiry Month</label>
				<input type="text" class="form-control" id="expiry_month" name="expiry_month" maxlength="5" />
		   </div>
		   
		   <div class="form-group">
				<label for="card_number">Expiry Year</label>
				<input type="text" class="form-control" id="expiry_year" name="expiry_year" maxlength="5" />
		   </div>
		   
		   <div class="form-group">
				<label for="card_number">CVV</label>
				<input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" />
		   </div>
		   
		   <div class="form-group">
				<label for="card_number">Name on Card</label>
				<input type="text" class="form-control" id="name_on_card" name="name_on_card" />
		   </div>
		   
		   <div class="form-group">
				<button id="cardSubmitBtn" name="card_submit"   type="button" class="btn btn-primary">Proceed</button>
		   </div>
		 
		 </form> 
		 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- End -->
  
</div>
<script src="js/creditcardvalidator.js"></script>
<script>
function Redirect() 
{  
   window.location="index.php"; 
} 
$(document).ready(function(){
    // Initiate validation on input fields
    /*$('#paymentForm input[type=text]').on('keyup',function(){
        cardFormValidate();
    });*/
    
    // Submit card form
    $("#cardSubmitBtn").on('click',function(){
        //$('.status-msg').remove();
        //if(cardFormValidate()){
            var formData = $('#paymentForm').serialize();
			//alert(formData);
            $.ajax({
                type:'POST',
                url:'paypal_pro_process.php',
                dataType: "json",
                data:formData,
				processData:false,
                beforeSend: function(){
                    $("#cardSubmitBtn").prop('disabled', true);
                    $("#cardSubmitBtn").val('Processing....');
                },
                success:function(res){
					//var res = JSON.parse(response);
                    if(res.status == 1){
                        $('#paymentSection').html('<p class="status-msg success">The transaction was successful. Order ID: <span>'+res.orderID+'</span></p>');
						$('#myModal').modal('toggle'); 
						setTimeout('Redirect()', 5000); 
                    }else{
                        $("#cardSubmitBtn").prop('disabled', false);
                        $("#cardSubmitBtn").val('Proceed');
                        $('#paymentSection').prepend('<p class="status-msg error">Transaction has been failed, please try again.</p>');
                    }
                }
            });
        //}
    });
});
</script>