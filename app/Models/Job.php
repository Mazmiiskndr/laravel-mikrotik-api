<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'command',
        'username',
        'nasipaddress',
        'framedipaddress',
        'payload',
        'attempts',
    ];
}
