<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'serial_number',
    ];

    /**
     * This method is called upon the model booting up.
     *
     * The creating Eloquent event is used here to
     * set the voucher_uid attribute and the serial_number attribute
     * every time a new model is created.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->voucher_uid = str()->uuid();
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
            $lastOrder = $this->orderBy('id', 'desc')->first();

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
