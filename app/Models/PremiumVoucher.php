<?php

namespace App\Models;

use App\Traits\UsesOrderedUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumVoucher extends Model
{
    use HasFactory, UsesOrderedUuid;

    protected $table = 'premium_vouchers';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'voucher_batch_id',
        'username',
        'password',
        'valid_until',
        'first_use',
        'status',
        'clean_up',
        'time_limit',
    ];
}
