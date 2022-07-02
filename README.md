# Safepay PHP SDK

Official PHP SDK for [Safepay API](https://getsafepay.com/).

# Installation

```
composer require getsafepay/safepay-php

```

# Usage

Import and create a Safepay client by passing your config;

```
use Safepay\Safepay;

$config = [
	"environment" =>'sandbox',
	"apiKey" => 'sec_e9273e07a7ac',
	"v1Secret" =>  'a73e5dad7cd8b1e7fea2f6d93f4c8',
	"webhookSecret" =>  '14509fdd8591a60427e'
	"channel" => 'accounts'   //optional
];

$Safepay = new Safepay($config);

```

You can now create payments and checkout links.

# Payments

```

$response = $Safepay->payments->getToken(['amount'=>1000,'currency'=>'PKR']);

//$response['token'];
// Pass `token` to create checkout link

```

# Checkout

Create checkout link

```
$link = $Safepay->checkout->create([
	"token" => $response['token'],
	"order_id" => 234,
	"source"=>'custom',
	"webhooks"=>true,
	"success_url" =>"url /success.php",
	"cancel_url" => "url  /cancel.php"

]);

//redirect user to url
if( $link['result'] == 'success' ) {
	header('Location:'.$link['redirect']);
}

```

# Verification

Signature verification on success page.

```

$tracker = $_POST['tracker'];

$signature = $_POST['sig'];

if( $Safepay->verify->signature($tracker,$signature)  === true) {

	//Signature is valid
}


```

# Webhook

Signature verification of Webhook post request

```
$X_SFPY_SIGNATURE = @$_SERVER['HTTP_X_SFPY_SIGNATURE'];


$data = file_get_contents('php://input');

if( $Safepay->verify->webhook($data,$X_SFPY_SIGNATURE)  === true) {

	//Web Hook request is valid
}

```
