<?php
/**
 * Stripe - Payment Gateway integration example (Stripe Checkout)
 * ==============================================================================
 * 
 * @version v1.0: stripe_pay_checkout_demo.php 2016/10/05
 * @copyright Copyright (c) 2016, http://www.ilovephp.net
 * @author Sagar Deshmukh <sagarsdeshmukh91@gmail.com>
 * You are free to use, distribute, and modify this software
 * ==============================================================================
 *
 */

// Stripe library
//require 'config.php';
require 'stripe/Stripe.php';
$erro=0;
$id=$_REQUEST['paykey'];
if(isset($id) && $id!='')
{
	$sql = "SELECT * FROM payment_logs WHERE id=$id";
	$result = $conn->query($sql);

	  if ($result->num_rows > 0) {
	    // output data of each row
		  $row = $result->fetch_assoc();
		  $logs=$row["logs"];
		} else {
		    echo "0 results";
	 }

	$data = json_decode($logs, true);

	$invoice=$data['invoiceno'];
	$currency=$data['currency'];
	$total=$data['total'];
	$gateway=$data['gateway'];
	$hashkey=$data['hashkey'];

	$amount_cents = $total;
	$amount_cents2 = str_replace(".","",$total);
	$invoiceid = $invoice; 
	$description = "Gateway #" . $gateway . " - Hashkey" . $hashkey;

	$sucess_url=SITEURL.'checkout/payment-success?gateway='.$gateway.'&invoiceNo='.$invoice.'&paykey='.$id.'&hashkey='.$hashkey.'';
	$failure_url=SITEURL.'checkout/payment-failure?gateway='.$gateway.'&invoiceNo='.$invoice.'&paykey='.$id.'&hashkey='.$hashkey.'';

	$params = array(
		"testmode"   => "on",
		"private_live_key" => "sk_live_xxxxxxxxxxxxxxxxxxxxx",
		"public_live_key"  => "pk_live_xxxxxxxxxxxxxxxxxxxxx",
		"private_test_key" => "sk_test_QeMGkgpQHrgYveBFoeWvPljz",
		"public_test_key"  => "pk_test_R0guMLUpL5gdFjVblL0O4cqx"
	);

	if ($params['testmode'] == "on") {
		Stripe::setApiKey($params['private_test_key']);
		$pubkey = $params['public_test_key'];
	} else {
		Stripe::setApiKey($params['private_live_key']);
		$pubkey = $params['public_live_key'];
	}

	if(isset($_POST['stripeToken']))
	{
		

		try {
			$charge = Stripe_Charge::create(array(		 
				  "amount" => $amount_cents2,
				  "currency" => $currency,
				  "source" => $_POST['stripeToken'],
				  "description" => $description)			  
			);

			if ($charge->card->address_zip_check == "fail") {
				throw new Exception("zip_check_invalid");
			} else if ($charge->card->address_line1_check == "fail") {
				throw new Exception("address_check_invalid");
			} else if ($charge->card->cvc_check == "fail") {
				throw new Exception("cvc_check_invalid");
			}
			// Payment has succeeded, no exceptions were thrown or otherwise caught				

			$result = "success";			

		} catch(Stripe_CardError $e) {			

		$error = $e->getMessage();
			$result = "declined";

		} catch (Stripe_InvalidRequestError $e) {
			$result = "declined";		  
		} catch (Stripe_AuthenticationError $e) {
			$result = "declined";
		} catch (Stripe_ApiConnectionError $e) {
			$result = "declined";
		} catch (Stripe_Error $e) {
			$result = "declined";
		} catch (Exception $e) {

			if ($e->getMessage() == "zip_check_invalid") {
				$result = "declined";
			} else if ($e->getMessage() == "address_check_invalid") {
				$result = "declined";
			} else if ($e->getMessage() == "cvc_check_invalid") {
				$result = "declined";
			} else {
				$result = "declined";
			}		  
		}
		
		if($result=='success')
		{
			$sql = "UPDATE payment_logs SET payment_status='paid' WHERE id=$id";
			$conn->query($sql);
			header('Location: '.$sucess_url);
			exit;
		} else {
			$sql = "UPDATE payment_logs SET payment_status='fail' WHERE id=$id";
			$conn->query($sql);
			header('Location: '.$failure_url);
			exit;
		}	
		//echo "<BR>Stripe Payment Status : ".$result;
		//echo "<BR>Stripe Response : ";
		//echo "<PRE>";
		//print_r($charge); exit;
	}
 } else {
 	$erro=1;
 }	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>EIG Stripe Pay</title>
<!-- core js -->
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<!-- bootstrap js -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- bootstrap style -->
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<!-- style-->
<link href="css/admin_style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.pay-btn { display: inline-block; margin: 10px; background: #000; color: #fff; min-width: 100px; padding: 10px 20px; text-decoration: none; outline: none; }
</style>
</head>
<body>
<h1 class="bt_title" align="center">EIG Stripe Pay</h1>
<?php if($erro==0){ ?>
<div align="center">
<p><b>Amout to pay: <?php echo $amount_cents.''.$currency; ?></b></p>
<p><b>Invoice id: <?php echo $invoiceid; ?></b></p>
</div>
<div align="center">
  <form action="" method="POST">
  <div class="p-page">
        	<div class="col-md-4 left-panel">
            	<div class="row">
                	<div class="logo">
                    	<img src="images/logo.png" class="img-responsive" />
                    </div>
                    <p>Payments powered by</p>
                    <h1>stripe</h1>
                    <div class="text-center left-button">
                    <a href="#" class="gback">Cancel and go back</a> 
                    </div>
                </div>
            </div>
            <div class="col-md-8 right-panel">
            	<div class="row">
                	<div class="panel-conent-box">
                    	<div class="content-box">
                        	<p class="small-title">Amount to pay</p>
                        	<h3>32.50 SGD</h3>                            
                        </div>
                        <div class="content-box">
                        	<p class="small-title">Invoice ID</p>
                        	<h3>EIGMARK-1499670931</h3>                            
                        </div>
                    
                    	<div class="p-card text-right">
                    		<a href="#" class="payment-c">PAY WITH CARD</a>
                    	</div>
                      </div>  
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        	
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?php echo $params['public_test_key']; ?>"
    data-amount="<?php echo $amount_cents2; ?>"
    data-name="EIG Stripe"
    data-description="<?php echo $description; ?>"
    data-image="https://www.arcadier.com/img/arcadierlogo.png"
    data-locale="auto"
    data-zip-code="true">
  </script>
  </form>
  <div align="center"><p><button type="button" class="stripe-button-el" style="visibility: visible;" onclick="window.location='<?php echo $failure_url;?>'"><span style="display: block; min-height: 30px;">Cancel and Go back</span></button></p></div>
</div>
<?php } else {
$failure_url=SITEURL.'checkout/payment-failure?gateway=&invoiceNo=&paykey=&hashkey=';
?>
<div align="center">
	<p><b>There is something wrong please contact site admin.</b></p>
	<p><a class="pay-btn" href="<?php echo $failure_url;?>">Click here to go bak</a></p>
</div>
<?php }?>
</body>
</html>