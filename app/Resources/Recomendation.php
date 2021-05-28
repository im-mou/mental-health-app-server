<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class Recomendation extends JsonResource
{

    public function toArray($request)
    {
        return [
            'recomendation_id'              => $this->id,
            'titulo'                        => $this->interest->subtitle,
            'url'                           => $this->interest->url,
            'description'                   => $this->description,
        ];
    }
}
