<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            [
                'id' => 1,
                'name' => 'login',
                'title' => 'Login',
                'is_parent' => 0,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0
            ],
            [
                'id' => 2,
                'name' => 'dashboard',
                'title' => 'Dashboard',
                'is_parent' => 0,
                'show_to' => NULL,
                'url' => "dashboard",
                'extensible' => 1,
                'active' => 1,
                'icon_class' => "ti ti-dashboard",
                'root' => 0
            ],
            [
                'id' => 3,
                'name' => 'clients',
                'title' => 'Clients',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 1,
                'active' => 1,
                'icon_class' => "ti ti-users",
                'root' => 0
            ],
            [
                'id' => 4,
                'name' => 'services',
                'title' => 'Services',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 1,
                'active' => 1,
                'icon_class' => "ti ti-package",
                'root' => 0
            ],
            [
                'id' => 5,
                'name' => 'logs',
                'title' => 'Logs',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 0,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0
            ],
            [
                'id' => 6,
                'name' => 'billing',
                'title' => 'Billing',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 0,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0
            ],
            [
                'id' => 7,
                'name' => 'reports',
                'title' => 'Reports',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 0,
                'active' => 1,
                'icon_class' => 'ti ti-chart-pie',
                'root' => 0
            ],
            [
                'id' => 8,
                'name' => 'utilities',
                'title' => 'Utilities',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 1,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0
            ],
            [
                'id' => 9,
                'name' => 'setup',
                'title' => 'Setup',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 1,
                'active' => 1,
                'icon_class' => 'ti ti-settings',
                'root' => 0
            ],
            [
                'id' => 10,
                'name' => 'administrators',
                'title' => 'Administrators',
                'is_parent' => 0,
                'show_to' => 9,
                'url' => 'administrators',
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0
            ],
            [
                'id' => 12,
                'name' => 'vouchers',
                'title' => 'Vouchers',
                'is_parent' => 0,
                'show_to' => 3,
                'url' => NULL,
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0
            ],
            [
                'id' => 13,
                'name' => 'hotel_rooms',
                'title' => 'Hotel Rooms',
                'is_parent' => 0,
                'show_to' => 3,
                'url' => NULL,
                'extensible' => 0,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0
            ],
            [
                'id' => 14,
                'name' => 'ads',
                'title' => 'Ads',
                'is_parent' => 0,
                'show_to' => 9,
                'url' => 'ads',
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0
            ],
            [
                'id' => 15,
                'name' => 'bypass_mac',
                'title' => 'Bypass Mac',
                'is_parent' => 0,
                'show_to' => 3,
                'url' => NULL,
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0
            ],
            [
                'id' => 16,
                'name' => 'users_data',
                'title' => 'Users Data',
                'is_parent' => 0,
                'show_to' => 3,
                'url' => 'users_data',
                'extensible' => 0,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0
            ],
            [
                'id' => 17,
                'name' => 'social_plugins',
                'title' => 'Social Plugins',
                'is_parent' => 0,
                'show_to' => 9,
                'url' => 'social_plugins',
                'extensible' => 0,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0
            ],
            // NOT MEGALOS STANDAR IF PREMIUM ACTIVE 👇
            [
                'id' => 18,
                'name' => 'premium',
                'title' => 'Premium',
                'is_parent' => 0,
                'show_to' => 3,
                'url' => NULL,
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0
            ],
            [
                'id' => 19,
                'name' => 'configs',
                'title' => 'Configs',
                'is_parent' => 0,
                'show_to' => 9,
                'url' => 'configs',
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0
            ]
        ];

        foreach ($modules as $module) {
            Module::insert($module);
        }
    }
}
