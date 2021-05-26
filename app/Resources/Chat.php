<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Chat extends JsonResource
{

    public function toArray($request)
    {
        $left = true;

        if($this->type == 'question'){
            $left = true;
        } elseif($this->type == 'answer') {
            $left = false;
        }

        return [
            'left'                  => $left,
            'text'                  => $this->body,
        ];
    }
}
