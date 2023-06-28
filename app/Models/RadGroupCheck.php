<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadGroupCheck extends Model
{
    use HasFactory;

    protected $table = 'radcheck';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'groupname',
        'attribute',
        'op',
        'value',
    ];
    public $timestamps = false;
}
