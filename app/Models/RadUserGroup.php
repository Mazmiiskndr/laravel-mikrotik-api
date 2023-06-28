<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadUserGroup extends Model
{
    use HasFactory;

    protected $table = 'radusergroup';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'username',
        'groupname',
        'priority',
        'user_type',
        'voucher_id',
    ];
    public $timestamps = false;
}
