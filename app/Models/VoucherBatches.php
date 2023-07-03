<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherBatches extends Model
{
    use HasFactory;

    protected $table = 'voucher_batches';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'voucher_batches_uid',
        'service_id',
        'quantity',
        'created',
        'created_by',
        'note',
        'type',
    ];

    /**
     * boot
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->voucher_batches_uid = str()->uuid();
        });
    }

    /**
     * Get the data service.
     */
    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id', 'id');
    }

    /**
     * Get the vouchers for the voucher batch.
     */
    public function vouchers()
    {
        return $this->hasMany(Voucher::class, 'voucher_batch_id');
    }
}
