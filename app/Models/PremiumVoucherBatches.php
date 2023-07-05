<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
