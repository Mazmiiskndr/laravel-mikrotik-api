<?php

namespace App\Models;

use App\Traits\UsesOrderedUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    use HasFactory, UsesOrderedUuid;

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
