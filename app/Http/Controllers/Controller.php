<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getCountryCodeFromIp($ip)
    {
        $result = DB::table('ip2nationCountries as c')->
        select('c.code')->
        join('ip2nation AS i', 'c.code', '=', 'i.country')->
        where('i.ip', '<', DB::raw('INET_ATON("'.$ip.'")'))->
        orderBy('i.ip', 'DESC')->
        first();

        return (is_object($result)) ? $result->code : null;
    }
}
