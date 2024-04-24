<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Openai extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'openai';

    public function chat()
    {
        return $this->belongsTo( Chat::class, 'id', 'chat_id');
    }
}
