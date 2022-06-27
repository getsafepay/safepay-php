<?php

namespace Safepay;

class Verify
{
	protected $options;

	public function __construct($options)
	{

		$this->options  = $options;
	}

	/**
	 *  verify safepay signature
	 * @param  string $tracker
	 */
	public function signature($tracker, $signature)
	{

		if (empty($tracker) || empty($signature)) {
			throw new \Exception("Missing parameters.", 1);
		}

		if (!isset($this->options['v1Secret'])) {
			throw new \Exception("Signature verification key is missing", 1);
		}


		return hash_hmac('sha256', $tracker, $this->options['v1Secret']) === $signature;
	}

	/**
	 * Verify Webhook request
	 */

	public function webhook($data_string, $x_sfpy_signature)
	{

		if (!is_string($data_string)) {
			throw new \Exception("Expecting string at first parameter given " . gettype($data_string), 1);
		}

		if (empty($x_sfpy_signature)) {
			throw new \Exception("Missing signature.", 1);
		}

		if (!isset($this->options['webhookSecret'])) {
			throw new \Exception("webhook Secret key is missing", 1);
		}

		return hash_hmac('sha512', $this->getPayload($data_string), $this->options['webhookSecret']) === $x_sfpy_signature;
	}

	private function getPayload(string $data)
	{

		$payload_array = json_decode($data, true);

		if (empty($payload_array)) {

			throw new \Exception("Payload is empty or illegal.", 1);
		}

		return json_encode($payload_array['data'], JSON_UNESCAPED_SLASHES);
	}
}
