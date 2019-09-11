<?php
/**
 * Created by PhpStorm.
 * User: MrCatz
 * Date: 13/09/18
 * Time: 12.39
 */

namespace App\Http\Controllers\api_query;

use Illuminate\Support\Facades\DB;

class BaseQuery{

    function curdate()
    {

        return DB::raw('curdate()');

    }


    function date_add($add)
    {

        return DB::raw('DATE_ADD(CURDATE(), INTERVAL '.$add.' DAY)');

    }

    function daynow()
    {

        return DB::raw('LOWER(DAYNAME(CURDATE()))');

    }

    function now()
    {

        return DB::raw('now()');

    }


    function curtime()
    {

        return date('H:i:s');

    }

    function rupiah($data)
    {
        return "Rp ".number_format($data, '0', ',', '.');
    }

    function SQLSRV($table)
    {

        return DB::connection('sqlsrv')->table($table);

    }

    function MYSQL($table)
    {

        return DB::connection('mysql')->table($table);

    }

}