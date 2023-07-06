<?php

namespace App\Models;

use App\Traits\UsesOrderedUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, UsesOrderedUuid;

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
