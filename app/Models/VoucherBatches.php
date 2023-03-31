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
}
