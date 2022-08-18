<?php

namespace Safepay;

use Safepay\Base;

class Checkout extends Base
{

	protected $options;

	protected $valid_options = ['token', 'order_id', 'success_url', 'cancel_url'];

	public function __construct($options)
	{

		$this->options = $options;

		$this->options['currency'] = $options['currency'] ?? static::CURRENCY;
	}

	/**
	 * Return Redirect url
	 */
	public function create(array $data)
	{

		$this->validate($data);

		$hosted_url = $this->setPaymentUrl($data);

		return array(
			'result'   => 'success',
			'redirect' => $hosted_url,
		);
	}

	private function validate(array $options)
	{

		foreach ($this->valid_options as $key => $option) {
			if (!isset($options[$option])) {
				throw new \Exception("{$option} is missing.", 1);
			}
		}
	}

	private function setPaymentUrl(array $data)
	{

		$URL = $this->options['environment'] == self::SANDBOX ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL;

		$webooks =  (bool) $data['webhooks'] ?? false;

		$baseURL = $URL . self::CHECKOUT_ROUTE;

		$params = array(
			"env"            => $this->options['environment'] == self::SANDBOX ? self::SANDBOX : self::PRODUCTION,
			"beacon"         => $data['token'],
			"source"         => $data['source'] ?? 'custom',
			"order_id"       => $data['order_id'],
			"redirect_url"   => $data['success_url'] ?? '',
			"cancel_url"     => $data['cancel_url'] ?? '',
			"webhooks"       => $webooks == true ? 'true' : 'false',
		);

		return $baseURL . "?" . http_build_query($params);
	}
}
