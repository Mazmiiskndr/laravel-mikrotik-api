<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UseUuid as Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'service_id',
        'customer_id',
        'username',
        'password',
        'enable_user',
        'simultaneous_use',
        'static_ip_address',
        'identification',
        'first_name',
        'last_name',
        'fullname',
        'birth_place',
        'birth_date',
        'phone',
        'mobile',
        'email',
        'company',
        'address',
        'city',
        'zip',
        'tax',
        'activation',
        'valid_until',
        'first_use',
        'status',
        'validfrom',
    ];

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id','id');
    }
}
