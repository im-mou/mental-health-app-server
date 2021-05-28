<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Interest extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                            => $this->id,
            'title'                         => $this->title,
            'subtitle'                      => $this->subtitle,
        ];
    }
}
