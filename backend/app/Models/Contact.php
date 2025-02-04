<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'contact_id',
        'nickname',
    ];

    // Связь с пользователем, который добавил контакт
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Связь с пользователем, которого добавили в контакты
    public function contactUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contact_id');
    }
}