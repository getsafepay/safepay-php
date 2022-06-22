<?php 

namespace SafePay;



abstract class Base {


	const SANDBOX                     = "sandbox";
    const PRODUCTION                  = "production";

    const CURRENCY = 'PKR';

    const PRODUCTION_CHECKOUT_URL     = "https://www.getsafepay.com/components";
    const SANDBOX_CHECKOUT_URL        = "https://sandbox.api.getsafepay.com/components";

    public static $init_transaction_endpoint = "order/v1/init";

    /** @var string Safepay sandbox API url. */
    public static $sandbox_api_url = 'https://sandbox.api.getsafepay.com/';

    /** @var string Safepay production API url. */
    public static $production_api_url = 'https://api.getsafepay.com/';


}