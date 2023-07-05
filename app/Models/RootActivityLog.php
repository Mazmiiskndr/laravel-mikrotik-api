<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RootActivityLog extends Model
{
    use HasFactory;

    protected $table = 'root_activity_log';

    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'action',
        'ip',
        'params',
        'time_of_action',
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
