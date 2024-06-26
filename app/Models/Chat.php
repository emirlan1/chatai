<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'context' => 'array'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id', 'id');
    }
}
