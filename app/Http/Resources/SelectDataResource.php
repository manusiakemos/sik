<?php

namespace App\Http\Resources;

class SelectDataResource
{

    public static function get($data ,$val="", $text="")
    {
        $arr = [];

        foreach ($data as $value){
            $arr[] = [
                "value" => $value->{$val},
                "text" => $value->{$text}
            ];
        }

        return response()->json($arr);
    }
}
