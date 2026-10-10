<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Primary key khusus sesuai database inventory.
     */
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'full_name',
        'role',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password_hash' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Nama kolom password untuk autentikasi Laravel.
     */
    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    /**
     * Mengambil hash password untuk autentikasi.
     */
    public function getAuthPassword(): string
    {
        return (string) $this->password_hash;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Histori transaksi stok yang dilakukan pengguna.
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(
            StockMovement::class,
            'user_id',
            'user_id'
        );
    }
}
