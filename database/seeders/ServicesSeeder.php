<?php

namespace Database\Seeders;

use App\Models\Services;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Services::create([
            'service_name' => 'DefaultService',
            'type' => 'Regular',
            'burst_mode' => '0',
            'ul_rate' => '1024',
            'dl_rate' => '1024',
            'ul_br_rate' => '0',
            'dl_br_rate' => '0',
            'ul_br_trh' => '768',
            'dl_br_trh' => '768',
            'ul_br_time' => '0',
            'dl_br_time' => '0',
            'priority' => '2',
            'session_timeout' => '0',
            'idle_timeout' => '0',
            'bandwidth_change' => '0',
            'from' => null,
            'to' => null,
            'bc_burst_mode' => '0',
            'bc_ul_rate' => null,
            'bc_dl_rate' => null,
            'bc_ul_br_rate' => null,
            'bc_dl_br_rate' => null,
            'bc_ul_br_trh' => null,
            'bc_dl_br_trh' => null,
            'bc_ul_br_time' => null,
            'bc_dl_br_time' => null,
            'bc_priority' => '0',
            'simultaneous_use' => '0',
            'validity_type' => 'none',
            'validity' => '0',
            'unit_validity' => 'days',
            'time_limit' => '0',
            'unit_time' => 'minutes',
            'time_limit_type' => 'none',
            'enable_limit' => '0',
            'cost' => '0.00',
            'currency' => 'IDR',
            'for_purchase' => '0',
            'purchase_duration' => '0',
            'unit_time_purchase' => 'hours',
            'description' => 'Default service 1mbps',
            'cron' => '1',
            'cron_type' => '0',
            'volume_limit' => '0',
            'volume_limit_unit' => 'MB',
            'volume_limit_bytes' => '0',
            'validfrom' => '0',
        ]);
    }
}
