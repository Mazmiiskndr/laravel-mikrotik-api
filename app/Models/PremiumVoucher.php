<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumVoucher extends Model
{
    use HasFactory;

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

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
    ];

    /**
     * Model "booting" method. Sets 'id' to a new UUID before record creation.
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = strtoupper(str()->uuid());
        });
    }
}
