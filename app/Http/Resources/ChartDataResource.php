<?php

namespace App\Http\Resources;

class ChartDataResource
{
    protected $value;
    protected $label;
    protected $data;

    public function __construct($data ,$value="", $label="")
    {
        $this->value = $value;
        $this->label = $label;
        $this->data = $data;
    }

    public function get()
    {
        $arr = [];
        $data = $this->data;

        foreach ($data as $value){
            $arr[] = [
                "label" => $value->{$this->label},
                "value" => $value->{$this->value}
            ];
        }

        return response()->json($arr);
    }
}
