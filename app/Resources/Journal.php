<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\Chat as ChatResource;

class Journal extends JsonResource
{

    public function toArray($request)
    {
        return [
            'user_id'                       => $this->user_id,
            'journal_id'                    => $this->id,
            'date'                          => $this->date,
            'color'                         => $this->color,
            'sentiment_index'               => $this->sentiment_index,
            'chat'                          => ChatResource::collection($this->chats),
        ];
    }
}
