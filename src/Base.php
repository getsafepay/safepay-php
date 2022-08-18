<?php

namespace Safepay;

abstract class Base
{

    const SANDBOX  = "sandbox";

    const PRODUCTION = "production";

    const CURRENCY = 'PKR';

    const PRODUCTION_BASE_URL = 'https://getsafepay.com';

    const SANDBOX_BASE_URL = 'https://sandbox.api.getsafepay.com';

    const CHECKOUT_ROUTE = '/checkout/pay';

    const TRANSACTION_ENDPOINT = '/order/v1/init';

    const SANDBOX_API_URL = 'https://sandbox.api.getsafepay.com/';

    const PRODUCTION_API_URL = 'https://api.getsafepay.com/';
}
