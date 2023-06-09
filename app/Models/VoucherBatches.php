<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class VoucherBatches extends Model
{
    use HasFactory;

    protected $table = 'voucher_batches';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'service_id',
        'quantity',
        'created',
        'created_by',
        'note',
        'type',
    ];

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
