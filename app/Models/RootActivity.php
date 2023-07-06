<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;
use App\Traits\UsesOrderedUuid;

class RootActivity extends Model
{
    use HasFactory, UsesOrderedUuid;

    protected $table = 'root_activities';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'username',
        'module',
        'page',
        'timestamp',
        'browser_name',
        'browser_version',
        'os_name',
        'os_version',
        'device_type',
        'params',
        'ip',
    ];
}
