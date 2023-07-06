<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

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
}
