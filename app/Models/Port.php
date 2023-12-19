<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Port extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    
    protected $fillable = [
        'bisnis_id','user_id','label','port','to_port','status'
    ];
 
    public function bisnis(): HasMany
    {
        return $this->hasMany(Bisnis::class,'id','bisnis_id');
    }

}
