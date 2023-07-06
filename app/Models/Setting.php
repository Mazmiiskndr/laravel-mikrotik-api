<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;
use App\Traits\UsesOrderedUuid;

class Setting extends Model
{
    use HasFactory, UsesOrderedUuid;

    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'module_id',
        'setting',
        'value',
        'flag_module',
    ];

    public $timestamps = false;

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }
}
