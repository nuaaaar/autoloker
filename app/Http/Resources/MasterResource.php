<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterResource extends JsonResource
{
    //public properti
    public $status;
    public $message;
    public $code;
    public static $wrap = 'results';


    public function __construct($status, $code, $message, $resource)
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->code  = $code;
        $this->message = $message;
    }


    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'code' => $this->code,
            'message'  => $this->message,
            'results'  => $this->resource
        ];
    }
}
