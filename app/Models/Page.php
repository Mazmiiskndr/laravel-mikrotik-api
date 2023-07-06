<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;
use App\Traits\UsesOrderedUuid;

class Page extends Model
{
    use HasFactory, UsesOrderedUuid;

    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'page',
        'title',
        'url',
        'module_id',
        'allowed_groups',
        'show_menu',
        'show_to',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }
}
