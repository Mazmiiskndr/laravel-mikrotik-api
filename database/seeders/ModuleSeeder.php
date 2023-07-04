<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Group;
use App\Models\Module;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Database\Seeders\SettingSeeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $modules;
    private $transformedGroups;

    public function __construct()
    {
        $this->transformedGroups = Group::all();
        $this->modules = [
            [
                'name' => 'login',
                'title' => 'Login',
                'is_parent' => 0,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => null,
                'pages_data' => null,
            ],
            [
                'name' => 'dashboard',
                'title' => 'Dashboard',
                'is_parent' => 0,
                'show_to' => NULL,
                'url' => "dashboard",
                'extensible' => 1,
                'active' => 1,
                'icon_class' => "ti ti-dashboard",
                'root' => 0,
                'settings_data' => null,
                'pages_data' => 2,
            ],
            [
                'name' => 'clients',
                'title' => 'Clients',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 1,
                'active' => 1,
                'icon_class' => "ti ti-users",
                'root' => 0,
                'settings_data' => 3,
                'pages_data' => 3,
            ],
            [
                'name' => 'services',
                'title' => 'Services',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 1,
                'active' => 1,
                'icon_class' => "ti ti-package",
                'root' => 0,
                'settings_data' => 4,
                'pages_data' => 4,
            ],
            [
                'name' => 'logs',
                'title' => 'Logs',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 0,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => null,
                'pages_data' => null,
            ],
            [
                'name' => 'billing',
                'title' => 'Billing',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 0,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => null,
                'pages_data' => null,
            ],
            [
                'name' => 'reports',
                'title' => 'Reports',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 0,
                'active' => 1,
                'icon_class' => 'ti ti-chart-pie',
                'root' => 0,
                'settings_data' => null,
                'pages_data' => 7,
            ],
            [
                'name' => 'utilities',
                'title' => 'Utilities',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 1,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => null,
                'pages_data' => null,
            ],
            [
                'name' => 'setup',
                'title' => 'Setup',
                'is_parent' => 1,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 1,
                'active' => 1,
                'icon_class' => 'ti ti-settings',
                'root' => 0,
                'settings_data' => null,
                'pages_data' => 9,
            ],
            [
                'name' => 'administrators',
                'title' => 'Administrators',
                'is_parent' => 0,
                'show_to' => 'setup',
                'url' => 'administrators',
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => null,
                'pages_data' => 10,
            ],
            [
                'name' => 'vouchers',
                'title' => 'Vouchers',
                'is_parent' => 0,
                'show_to' => 'clients',
                'url' => NULL,
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => null,
                'pages_data' => 12,
            ],
            [
                'name' => 'hotel_rooms',
                'title' => 'Hotel Rooms',
                'is_parent' => 0,
                'show_to' => 'clients',
                'url' => NULL,
                'extensible' => 0,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => 13,
                'pages_data' => 13,
            ],
            [
                'name' => 'ads',
                'title' => 'Ads',
                'is_parent' => 0,
                'show_to' => 'setup',
                'url' => 'ads',
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => 14,
                'pages_data' => 14,
            ],
            [
                'name' => 'bypass_mac',
                'title' => 'Bypass Mac',
                'is_parent' => 0,
                'show_to' => 'clients',
                'url' => NULL,
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => 15,
                'pages_data' => 15,
            ],
            [
                'name' => 'users_data',
                'title' => 'Users Data',
                'is_parent' => 0,
                'show_to' => 'clients',
                'url' => 'users_data',
                'extensible' => 0,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => 16,
                'pages_data' => 16,
            ],
            [
                'name' => 'social_plugins',
                'title' => 'Social Plugins',
                'is_parent' => 0,
                'show_to' => 'setup',
                'url' => 'social_plugins',
                'extensible' => 0,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => 17,
                'pages_data' => 17,
            ],
            // NOT MEGALOS STANDAR IF PREMIUM ACTIVE 👇
            [
                'name' => 'premium',
                'title' => 'Premium',
                'is_parent' => 0,
                'show_to' => 'clients',
                'url' => NULL,
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => 18,
                'pages_data' => 18,
            ],
            [
                'name' => 'configs',
                'title' => 'Configs',
                'is_parent' => 0,
                'show_to' => 'setup',
                'url' => 'configs',
                'extensible' => 0,
                'active' => 1,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => null,
                'pages_data' => 19,
            ],
            [
                'name' => 'router',
                'title' => 'Router',
                'is_parent' => 0,
                'show_to' => NULL,
                'url' => NULL,
                'extensible' => 0,
                'active' => 0,
                'icon_class' => NULL,
                'root' => 0,
                'settings_data' => 'default',
                'pages_data' => null,
            ]
        ];
    }

    public function run()
    {
        foreach ($this->modules as $module) {
            $createdModule = Module::create([
                'name' => $module['name'],
                'title' => $module['title'],
                'is_parent' => $module['is_parent'],
                'show_to' => $module['show_to'] ? $this->_getShowToId($module['show_to']) : $module['show_to'],
                'url' => $module['url'],
                'extensible' => $module['extensible'],
                'active' => $module['active'],
                'icon_class' => $module['icon_class'],
                'root' => $module['root']
            ]);

            $settingsData = SettingSeeder::getSetting($module['settings_data']);
            $pagesData = PageSeeder::getPages($module['pages_data']);

            if ($settingsData) {
                # code...
                foreach ($settingsData as $key => $value) {
                    # code...
                    Setting::create([
                        'module_id'   => $createdModule->id,
                        'setting'     => $value['setting'],
                        'value'       => $value['value'],
                        'flag_module' => $value['flag_module'],
                    ]);
                }
            }

            if ($pagesData) {
                # code...
                foreach ($pagesData as $key => $value) {
                    # code...
                    $newAllowedGroups = $this->_getNewAllowedGroupId(explode(',', $value['allowed_groups']));

                    Page::create([
                        'module_id'      => $createdModule->id,
                        'page'           => $value['page'],
                        'title'          => $value['title'],
                        'url'            => $value['url'],
                        'allowed_groups' => $newAllowedGroups,
                        'show_menu'      => $value['show_menu'],
                        'show_to'        => $value['show_to'] ? $createdModule->id : $value['show_to'],
                    ]);
                }
            }
        }
    }

    private function _getNewAllowedGroupId(array $oldAllowedGroup): string
    {
        $array = [];
        $transformedGroups = $this->transformedGroups->map(function ($item) {
            if ($item->name == 'Full Administrator') {
                $item->old_id = 1;
            } else {
                $item->old_id = 2;
            }

            return $item;
        });

        foreach ($oldAllowedGroup as $key => $value) {
            # code...
            $array[] = $transformedGroups->where('old_id', $value)->first()->id;
        }

        return implode(',', $array);
    }

    private function _getShowToId(string $oldShowTo): string
    {
        $module = Module::where('name', $oldShowTo)->first();
        return $module ? $module->id : null;
    }
}
