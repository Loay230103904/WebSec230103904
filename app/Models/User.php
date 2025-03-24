<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'credit'
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

    // ✅ Check if user is Admin
    public function isAdmin()
    {
        return isset($this->role) && $this->role === 'admin';
    }

    // ✅ Check if user is an Employee
    public function isEmployee()
    {
        return $this->role === 'employee';
    }

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }
    
}
