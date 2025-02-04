<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Связь с контактами (которые добавил этот пользователь)
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'user_id');
    }

    // Связь с контактами (где этот пользователь добавлен как контакт)
    public function addedBy(): HasMany
    {
        return $this->hasMany(Contact::class, 'contact_id');
    }
}