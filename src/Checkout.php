<?php 

namespace SafePay;

use SafePay\Base;

class Checkout extends Base {

	protected $options;

	protected $validate_options = [
									'token',
									'order_id',
									'success_url',
									'cancel_url'
								];


	public function __construct($options) {


		$this->options = $options;

		$this->options['currency'] = $options['currency']??static::CURRENCY;

	}


	/**
	 * Return Redirect url
	 */
	public function create(array $data) {

		$this->validate($data);

        $baseURL = $this->options['environment'] == "sandbox" ? self::SANDBOX_CHECKOUT_URL : self::PRODUCTION_CHECKOUT_URL;
        $params = array(
            "env"            => $this->options['environment'] == "sandbox" ? self::SANDBOX : self::PRODUCTION,
            "beacon"         => $data['token'],
            "source"         => $data['source']??'custom',
            "order_id"       => $data['order_id'],
            "redirect_url"   => $data['success_url']??'',
            "cancel_url"     => $data['cancel_url']??'',
            "webhooks"       => $data['webhooks']??false,
        );

        $hosted_url = $baseURL. "?".http_build_query($params);

        return array(
                'result'   => 'success',
                'redirect' => $hosted_url,
         	);

	}


	private function validate(array $options) {

    	foreach ($this->validate_options as $key => $option) {
    		if( !isset($options[$option]) ) {
    			throw new \Exception("{$option} is missing.", 1);
    			
    		}
    	}
    }

	 	



}