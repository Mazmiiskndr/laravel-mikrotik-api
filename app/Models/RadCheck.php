<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadCheck extends Model
{
    use HasFactory;

    protected $table = 'radcheck';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'username',
        'attribute',
        'op',
        'value',
    ];
    public $timestamps = false;
}
