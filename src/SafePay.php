<?php
namespace SafePay;

use SafePay\Payments;
use SafePay\Checkout;
use SafePay\Verify;

/**
 * Safepay base class
 */
class SafePay
{
	

    protected $options;

    public $checkout;

    public $payments;

    public $verify;

    private $valid_options = ['environment','apiKey','webhookSecret','v1Secret'];



    public function __construct(array $options) {
    	
    	if( empty($options) ) {
    		throw new \Exception("configuration is missing.");
    	}

    	$this->validate($options);

    	$this->options['environment'] = $options['environment'];
    	$this->options['apiKey'] = $options['apiKey'];
    	$this->options['webhookSecret'] = $options['webhookSecret'];
    	$this->options['v1Secret'] = $options['v1Secret'];
    	$this->options['channel'] = 'accounts';

   		
    	
    	$this->payments = new Payments($this->options);
    	$this->checkout = new Checkout($this->options);
    	$this->verify = new Verify($this->options);

    }



    private function validate(array $options) {

    	foreach ($this->valid_options as $key => $option) {
    		if( !isset($options[$option]) ) {
    			throw new \Exception("{$option} is missing in configuration", 1);
    			
    		}
    	}
    }

}