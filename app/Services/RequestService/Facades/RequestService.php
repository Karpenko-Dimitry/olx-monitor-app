<?php

namespace App\Services\RequestService\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ApiRequest
 * @package App\Services\ApiRequestService\Facades
 */
class RequestService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'api_request';
    }
}
