<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'token'                     => $this->password,
            'name'                      => $this->name,
            'sleep_time'                => $this->sleep_time,
            'notifications'             => $this->notifications,
        ];
    }
}
