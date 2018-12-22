<?php
namespace App\Log;
use \Illuminate\Http\Request;

/**
 * Class LogAllRequests
 * @package App\Log
 */
class LogAllRequests implements \Spatie\HttpLogger\LogProfile
{

    /**
     * @param Request $request
     * @return bool
     */
    public function shouldLogRequest(Request $request): bool
    {
        return in_array(strtolower($request->method()), ['post','get', 'put', 'patch', 'delete']);
    }
}
