<?php

namespace App\Models;

use App\Traits\UsesOrderedUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory, UsesOrderedUuid;

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
