<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class Ad extends Model
{
    use HasFactory;

    protected $table = 'ad';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'file_name',
        'thumb_file_name',
        'title',
        'short_description',
        'promo_date',
        'url_for_image',
        'url_for_read_more',
        'time_to_show',
        'time_to_hide',
        'device_type',
        'type',
        'position',
    ];
}
