<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    use HasFactory;

    protected $table = 'hotel_rooms';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'room_number',
        'name',
        'folio_number',
        'service_id',
        'default_cron_type',
        'status',
        'edit',
        'change_service_end_time',
        'arrival',
        'departure',
        'no_posting',
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
