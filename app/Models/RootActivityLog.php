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
}
