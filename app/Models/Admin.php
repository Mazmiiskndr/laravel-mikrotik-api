<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;
use App\Traits\UsesOrderedUuid;

class Admin extends Model
{
    use HasFactory, UsesOrderedUuid;

    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'group_id',
        'username',
        'password',
        'fullname',
        'email',
        'status',
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'admin_id', 'module_id');
    }

    /**
     * group
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
