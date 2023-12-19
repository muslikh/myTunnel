<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    
    protected $fillable = [
        'id', 'name','slug','harga','deskripsi'
    ];

    public function server(): HasMany
    {
        return $this->hasMany(Server::class);
    }
    public function bisnis(): HasMany
    {
        return $this->hasMany(Bisnis::class);
    }
}
