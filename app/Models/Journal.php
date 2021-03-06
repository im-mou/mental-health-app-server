<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'date',
        'color',
        'sentiment_index',
        'remaining_questions'
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
