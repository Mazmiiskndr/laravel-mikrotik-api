<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

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
}
