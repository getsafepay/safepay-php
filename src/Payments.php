<?php 

namespace SafePay;

use SafePay\Lib\Requestor;
use SafePay\Base;

class Payments extends Base {

	protected $options;

	
	public function __construct(array $options) {

		$this->options = $options;

		$this->options['currency'] = $options['currency']??static::CURRENCY;

	}


	public function getToken(array $data) {

		try {

			$res = $this->create_charge($data);

			if (!isset($res[0])) {
                return array('result' => $res[1]);
            }

            return $res[1]['data']??[];

		}catch(\Exception $e) {

			throw new \Exception($e->getMessage());
			
		}



	}


	 /**
     * Create a new charge request.
     * @param  int    $amount
     * @param  string $currency
     * @param  array  $metadata
     * @param  string $redirect
     * @param  string $name
     * @param  string $desc
     * @param  string $cancel
     * @return array
     */
    private function create_charge(array $data)
    {	

    	try {
        $args["environment"] = $this->options['environment'];

        $args["amount"] = floatval($data['amount']);

        $args["currency"] = $this->options['currency'];

         $args["client"] = $this->options['apiKey'];
       
    	}catch(\Exception $e){
    		throw new \Exception($e->getMessage());
    		
    	}

        return Requestor::send_request($this->options['environment'], self::$init_transaction_endpoint, $args, 'POST');

    }


}