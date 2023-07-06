<?php

namespace App\Models;

use App\Traits\UsesOrderedUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumSession extends Model
{
    use HasFactory, UsesOrderedUuid;

    protected $table = 'premium_sessions';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'username',
        'expiration',
    ];
}
