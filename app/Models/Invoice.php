<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'inv_id',
        'invoice_date',
        'payment_date',
        'user_id',
        'status',
        'tariff_name',
        'tariff_expiry_date',
        'gpt3_tokens',
        'gpt4_tokens',
    ];

    // Определяем отношение к модели пользователей (если оно есть)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
