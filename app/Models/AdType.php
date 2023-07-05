<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class AdType extends Model
{
    use HasFactory;

    protected $table = 'ad_type';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'name',
        'title',
        'max_height',
        'max_width',
        'max_size',
        'mobile_max_height',
        'mobile_max_width',
        'mobile_max_size',
        'single_image',
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
