<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;
use App\Traits\UsesOrderedUuid;

class Module extends Model
{
    use HasFactory, UsesOrderedUuid;

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
