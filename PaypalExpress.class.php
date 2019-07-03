<?php
/*
 * PaypalExpress Class
 * This class is used to handle PayPal API related operations
 * @author    CodexWorld.com
 * @url        http://www.codexworld.com
 * @license    http://www.codexworld.com/license
 */
class PaypalExpress{
    public $paypalEnv       = 'sandbox'; // Or 'production'
    public $paypalURL       = 'https://api.sandbox.paypal.com/v1/';
    public $paypalClientID  = 'AX1TUH6mLq76QcVgTXzRZnasvKT8POA-m5lRMlWIdqi7LAfZ0SxtzMJt0nclTPPpOhqaS6gqJoBI3lHF';
    private $paypalSecret   = 'EAlsXFIWFU5JFgc9VAcE9yqnW3SUJ-NFqn9LP5oMhuyHlXAsQeTf6Ht38fnE9FyYuOIubhwEL-oT-NsL';
	//public $paypalClientID  = 'AQv9Va8xU1g91hQHr1pQ-qUSDVSehLhUT3D8xZTpTNYyM9dqkbO8Hg1vGcfTLDP83HRliUpxdBbMlDFC';
    //private $paypalSecret   = 'EFQ7Tb48PtjEUymk4PbEZiIvGC_FDrD-aQgJ-xfx2_g1PdVC9V1M1kdtawxuKYcpUINQkPY123d_81ud';
	//public $paypalClientID  = 'AaxCa5kGVyvCevSG7xdUpzOniFbpdm6z1bYyh5QfWiANFhocnqWBnAKEVdS9YTweKN7fle616J7XWEDA';
    //private $paypalSecret   = 'EE5_XnkP3K92i3FvNHI42_Slt2XIj-ZbLmjVIy8iKwyXOfg_huc-uVeZ8UEY_xscV9vx2TZO4VNG-K0A';
    
    public function validate($paymentID, $paymentToken, $payerID, $productID=''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->paypalURL.'oauth2/token');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->paypalClientID.":".$this->paypalSecret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $response = curl_exec($ch);
        curl_close($ch);
        
        if(empty($response)){
            return false;
        }else{
            $jsonData = json_decode($response);
            $curl = curl_init($this->paypalURL.'payments/payment/'.$paymentID);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $jsonData->access_token,
                'Accept: application/json',
                'Content-Type: application/xml'
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            
            // Transaction data
            $result = json_decode($response);
            
            return $result;
        }
    
    }
}
