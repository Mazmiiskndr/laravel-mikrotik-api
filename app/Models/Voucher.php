<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'voucher_uid',
        'voucher_batch_id',
        'username',
        'password',
        'valid_until',
        'first_use',
        'status',
        'clean_up',
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
            $model->voucher_uid = str()->uuid();
        });
    }

    public function voucherBatch()
    {
        return $this->belongsTo(VoucherBatches::class, 'voucher_batch_id', 'id');
    }
}
