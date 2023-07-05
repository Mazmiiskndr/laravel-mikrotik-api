<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class Admin extends Model
{
    use HasFactory;

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

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
    ];

    /**
     * Model "booting" method. Sets 'id' to a new UUID before record creation.
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = strtoupper(str()->uuid());
        });
    }

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
