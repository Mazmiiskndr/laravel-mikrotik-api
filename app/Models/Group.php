<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;
use App\Traits\UsesOrderedUuid;

class Group extends Model
{
    use HasFactory, UsesOrderedUuid;

    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'name',
    ];

    /**
     * admins
     */
    public function admins()
    {
        return $this->hasMany(Admin::class, 'group_id', 'id');
    }

    /**
     * modules
     */
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'pages', 'allowed_groups', 'module_id')
            ->distinct()
            ->with('pages');
    }
}
