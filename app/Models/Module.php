<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'name',
        'title',
        'is_parent',
        'show_to',
        'url',
        'extensible',
        'active',
        'icon_class',
        'root',
    ];

    public $timestamps = false;

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

    public function pages()
    {
        return $this->hasMany(Page::class, 'module_id', 'id');
    }

    public function settings()
    {
        return $this->hasMany(Setting::class, 'module_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Module::class, 'root', 'id');
    }
}
