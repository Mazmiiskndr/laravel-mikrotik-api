<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadAcct extends Model
{
    use HasFactory;

    protected $table = 'radacct';
    protected $primaryKey = 'radacctid';
    protected $guarded = [];
    protected $fillable = [
        'radacctid',
        'acctsessionid',
        'acctuniqueid',
        'username',
        'groupname',
        'realm',
        'nasipaddress',
        'nasportid',
        'nasporttype',
        'acctstarttime',
        'acctstoptime',
        'acctsessiontime',
        'acctauthentic',
        'connectinfo_start',
        'connectinfo_stop',
        'acctinputoctets',
        'acctoutputoctets',
        'calledstationid',
        'callingstationid',
        'acctterminatecause',
        'servicetype',
        'framedprotocol',
        'framedipaddress',
        'acctstartdelay',
        'acctstopdelay',
        'xascendsessionsvrkey',
        'acctupdatetime',
        'acctinterval',
        'framedipv6address',
        'framedipv6prefix',
        'framedinterfaceid',
        'delegatedipv6prefix',
    ];
    public $timestamps = false;
}
