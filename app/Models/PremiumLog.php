<?php

namespace App\Models;

use App\Traits\UsesOrderedUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumLog extends Model
{
    use HasFactory, UsesOrderedUuid;

    protected $table = 'premium_logs';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'voucher_batch_id',
        'date',
        'operator',
        'quantity',
        'service',
    ];
}
