<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to TradeFi!</title>
</head>
<style>
	.btn {
		
	}

	.btn.btn-complete {
		
	}
</style>
<body>
	<div style="text-align: center">	
		 <img width="100" src="http://tradefi.ng/assets/images/logo-no-bg.jpg" alt="">
	</div>
	<h3>Welcome to TradeFi!</h3>
	Dear <b>{{ $firstname. ' '. $lastname }}</b>, <br>
	
	 <br>
	

	<p>Thank you for signing up to the TradeFi platform. To ensure that your registered email is valid, please confirm by clicking the button below.</p> <br>	

<div style="text-align: center">	
		<a href="{{ route('users.verify', [$code]) }}" class="btn btn-complete" style="padding: 10px 25px;
    text-decoration: none;
   background: #03A9F4;
    color: #fff;
    display: inline-block;
    border-radius: 3px;
    border-color: transparent;">Activate</a>
	</div> <br>	

	Your registration is under processing and account will be activated within 48 hours. You will be notified via the registered email when your account is activated, but if there are any challenges with registration details, the TradeFi team will reach out to you.</p>

<p>Thank you.</p>

<p>TradeFi Team.</p>

<p>If you have any concerns, please contact us through the help desk on <a href="mailto:info@tradefi.ng">info@tradefi.ng</a> </p>




	
</body>
</html>