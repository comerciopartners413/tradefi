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
	Dear! <b>{{ $firstname. ' '. $lastname }}</b>, <br>
	<p>Please confirm your e-mail address by clicking the button below</p>
	<a href="{{ route('users.verify', [$code]) }}" class="btn btn-complete" style="padding: 10px 25px;
    text-decoration: none;
   background: #03A9F4;
    color: #fff;
    display: inline-block;
    border-radius: 3px;
    border-color: transparent;">Activate</a>

<p>
	<b>Why?</b> We need to be sure it is really you. 
</p>

<p>
	Your account should take 48 hours to be activated, but if there are any problems with your KYC the team will reach out to you. You will be notified once your account is activated.
</p>

<p>Thank you </p>
<p>TradeFi Team.</p>



	
</body>
</html>