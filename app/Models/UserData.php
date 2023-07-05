<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $table = 'users_data';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'room_number',
        'date',
        'first_name',
        'last_name',
        'location',
        'gender',
        'birthday',
        'login_with',
        'mac',
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
