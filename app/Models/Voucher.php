<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;
use Illuminate\Support\Facades\DB;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';
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
        'serial_number',
    ];

    /**
     * Model "booting" method. Sets 'serial_number' to a new generated serial number before record creation.
     * Note: This model uses the 'UsesUuid' trait which sets 'id' to a new UUID before record creation.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->serial_number = $model->generateSerialNumber();
        });
    }


    /**
     * Define an inverse one-to-one or many relationship with the VoucherBatch model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function voucherBatch()
    {
        return $this->belongsTo(VoucherBatches::class, 'voucher_batch_id', 'id');
    }

    /**
     * Generate a new serial number for a Voucher.
     * The generated serial number is of the form MGL000000xx
     * where xx is an integer that increments with every new Voucher.
     * @return string The newly generated serial number.
     */
    protected function generateSerialNumber()
    {
        return DB::transaction(function () {
            // Fetch the last created order
            $lastOrder = $this->latest()->first();

            // Get the order number of the last order
            $lastOrderNumber = $lastOrder ? $lastOrder->serial_number : 'MGL00000000';

            // Strip the "MGL" prefix and convert the remaining string to an integer
            $orderNumber = intval(substr($lastOrderNumber, 3));

            // Increment the order number
            $newOrderNumber = $orderNumber + 1;

            // Zero-pad the order number to 8 digits
            $newOrderNumber = str_pad($newOrderNumber, 8, "0", STR_PAD_LEFT);

            // Return the new order number with the "MGL" prefix
            return 'MGL' . $newOrderNumber;
        });
    }


}
