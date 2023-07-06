<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class PremiumVoucherBatches extends Model
{
    use HasFactory;

    protected $table = 'premium_voucher_batches';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'service_id',
        'quantity',
        'created',
        'created_by',
        'note',
        'premium_service_end_time',
        'status',
        'type',
    ];
}
