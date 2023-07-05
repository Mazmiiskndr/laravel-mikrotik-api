<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'service_name',
        'type',
        'burst_mode',
        'ul_rate',
        'dl_rate',
        'ul_br_rate',
        'dl_br_rate',
        'ul_br_trh',
        'dl_br_trh',
        'ul_br_time',
        'dl_br_time',
        'priority',
        'session_timeout',
        'idle_timeout',
        'bandwidth_change',
        'from',
        'to',
        'bc_burst_mode',
        'bc_ul_rate',
        'bc_dl_rate',
        'bc_ul_br_rate',
        'bc_dl_br_rate',
        'bc_ul_br_trh',
        'bc_dl_br_trh',
        'bc_ul_br_time',
        'bc_dl_br_time',
        'bc_priority',
        'simultaneous_use',
        'validity_type',
        'validity',
        'unit_validity',
        'time_limit',
        'unit_time',
        'time_limit_type',
        'enable_limit',
        'cost',
        'currency',
        'for_purchase',
        'purchase_duration',
        'unit_time_purchase',
        'description',
        'cron',
        'cron_type',
        'volume_limit',
        'volume_limit_unit',
        'volume_limit_bytes',
        'validfrom',
    ];

    public $timestamps = false;

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
