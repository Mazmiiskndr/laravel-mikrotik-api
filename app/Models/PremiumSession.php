<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class PremiumSession extends Model
{
    use HasFactory;

    protected $table = 'premium_sessions';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'username',
        'expiration',
    ];
}
