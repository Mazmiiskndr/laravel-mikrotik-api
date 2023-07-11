<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class Mac extends Model
{
    use HasFactory;

    protected $table = 'macs';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'mac_address',
        'password',
        'mikrotik_group',
        'validfrom',
        'validto',
        'status',
        'description',
        'server',
        'mikrotik_id',
        'created_at',
        'updated_at',
    ];
}
