<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\Chat as ChatResource;

class Journal extends JsonResource
{

    public function toArray($request)
    {
        return [
            'journal_id'                    => $this->id,
            'user_id'                       => $this->user_id,
            'date'                          => $this->date,
            'color'                         => $this->color,
            'sentiment_index'               => $this->sentiment_index,
            'chat'                          => ChatResource::collection($this->chats),
        ];
    }
}
