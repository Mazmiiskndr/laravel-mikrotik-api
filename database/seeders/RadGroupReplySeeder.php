<?php

namespace Database\Seeders;

use App\Models\RadGroupReply;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RadGroupReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RadGroupReply::create([
            'groupname' => 'DefaultService',
            'attribute' => 'Mikrotik-Rate-Limit',
            'op' => ':=',
            'value' => '2048k/2048k',
        ]);
    }
}
