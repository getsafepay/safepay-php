<?php

namespace Safepay;

use Safepay\Payments;
use Safepay\Checkout;
use Safepay\Verify;
use Safepay\Base;

/**
 * Safepay base class
 */
class Safepay extends Base
{

	protected $options;

	public $checkout;

	public $payments;

	public $verify;

	private $valid_options = ['environment', 'apiKey', 'webhookSecret', 'v1Secret'];


	public function __construct(array $options)
	{
		
		if (empty($options)) {
			throw new \Exception("configuration is missing.");
		}

		$this->validate($options);

		if ($options['environment'] != static::SANDBOX  && $options['environment'] != static::PRODUCTION) {
			throw new \Exception("Safepay does not support " . $options['environment'] . " environment.", 1);
		}

		$this->options['environment'] = $options['environment'];
		$this->options['apiKey'] = $options['apiKey'];
		$this->options['webhookSecret'] = $options['webhookSecret'];
		$this->options['v1Secret'] = $options['v1Secret'];

		$this->payments = new Payments($this->options);
		$this->checkout = new Checkout($this->options);
		$this->verify = new Verify($this->options);
	}

	private function validate(array $options)
	{

		foreach ($this->valid_options as $key => $option) {
			if (!isset($options[$option])) {
				throw new \Exception("{$option} is missing in configuration", 1);
			}
		}
	}
}
