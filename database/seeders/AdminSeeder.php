<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'username' => 'root',
                'password' => 'radvar#123',
                'fullname' => 'Varnion Root',
                'email' => 'root@megalos.com',
                'status' => 1,
                'group_name' => 'Full Administrator'
            ],
            [
                'username' => 'admin',
                'password' => 'admin',
                'fullname' => 'Megalos Admin',
                'email' => 'admin@megalos.com',
                'status' => 1,
                'group_name' => 'Operator'
            ]
        ];

        foreach ($admins as $key => $value) {
            # code...
            Group::factory()->create([
                'name' => $value['group_name']
            ])->admins()->create([
                'username' => $value['username'],
                'password' => Hash::make($value['password']),
                'fullname' => $value['fullname'],
                'email' => $value['email'],
                'status' => $value['status']
            ]);
        }

        Group::inRandomOrder()->each(function ($group) {
            $group->admins()->saveMany(Admin::factory(10)->make());
        });
    }
}
