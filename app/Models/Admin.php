<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'admin_uid',
        'group_id',
        'username',
        'password',
        'fullname',
        'email',
        'status',
    ];

    /**
     * boot
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->admin_uid = str()->uuid();
        });
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'admin_module', 'admin_id', 'module_id');
    }

    /**
     * group
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
