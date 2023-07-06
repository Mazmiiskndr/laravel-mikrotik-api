<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class PremiumLog extends Model
{
    use HasFactory;

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
