<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'id' => 1,
                'page' => 'index',
                'title' => 'Main Homepage',
                'url' => 'home',
                'module_id' => 2,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 2,
                'page' => 'list_clients',
                'title' => 'List Clients',
                'url' => 'clients/list-clients',
                'module_id' => 3,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 3,
                'page' => 'add_new_client',
                'title' => 'Add New Client',
                'url' => '#',
                'module_id' => 3,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 4,
                'page' => 'edit_client',
                'title' => 'Edit Client',
                'url' => '#',
                'module_id' => 3,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 5,
                'page' => 'delete_client',
                'title' => 'Delete Client',
                'url' => '#',
                'module_id' => 3,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 7,
                'page' => 'list_services',
                'title' => 'List Services',
                'url' => 'services/list-services',
                'module_id' => 4,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 8,
                'page' => 'add_new_service',
                'title' => 'Add New Service',
                'url' => 'services/add-new-service',
                'module_id' => 4,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 9,
                'page' => 'edit_service',
                'title' => 'Edit Service',
                'url' => 'services/edit-service',
                'module_id' => 4,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 10,
                'page' => 'delete_service',
                'title' => 'Delete Service',
                'url' => 'services/pg/delete_service',
                'module_id' => 4,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            // TODO: MY ACCOUNT
            // [
            //     'id' => 11,
            //     'page' => 'my_account',
            //     'title' => 'My Account',
            //     'url' => 'administrators/pg/my_account',
            //     'module_id' => 10,
            //     'allowed_groups' => '1',
            //     'show_menu' => 1,
            //     'show_to' => NULL
            // ],
            [
                'id' => 12,
                'page' => 'list_admins',
                'title' => 'List Admins',
                'url' => 'setup/admin/list-admins',
                'module_id' => 10,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 13,
                'page' => 'list_groups',
                'title' => 'List Groups',
                'url' => 'setup/admin/list-groups',
                'module_id' => 10,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            // *** TODO: ***
            [
                'id' => 14,
                'page' => 'add_new_admin',
                'title' => 'Add New Admin',
                'url' => '#',
                'module_id' => 10,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 15,
                'page' => 'add_new_group',
                'title' => 'Add New Group',
                'url' => 'setup/admin/add-new-group',
                'module_id' => 10,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 16,
                'page' => 'edit_admin',
                'title' => 'Edit Admin',
                'url' => '#',
                'module_id' => 10,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 17,
                'page' => 'edit_group',
                'title' => 'Edit Group',
                'url' => 'setup/admin/edit-group',
                'module_id' => 10,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 18,
                'page' => 'delete_admin',
                'title' => 'Delete Admin',
                'url' => '#',
                'module_id' => 10,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 19,
                'page' => 'delete_group',
                'title' => 'Delete Group',
                'url' => 'administrators/pg/delete_group',
                'module_id' => 10,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 25,
                'page' => 'list_online_users',
                'title' => 'List Online Users',
                'url' => 'reports/list-online-users',
                'module_id' => 7,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 26,
                'page' => 'create_voucher_batch',
                'title' => 'Create Voucher Batch',
                'url' => '#',
                'module_id' => 12,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 27,
                'page' => 'list_voucher_batches',
                'title' => 'List Voucher Batches',
                'url' => 'clients/voucher/list-voucher-batches',
                'module_id' => 12,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 28,
                'page' => 'delete_voucher_batch',
                'title' => 'Delete Voucher Batch',
                'url' => '#',
                'module_id' => 12,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 29,
                'page' => 'delete_voucher_batches',
                'title' => 'Delete Voucher Batches',
                'url' => '#',
                'module_id' => 12,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 30,
                'page' => 'list_active_vouchers',
                'title' => 'List Active Vouchers',
                'url' => 'clients/pg/list_active_vouchers',
                'module_id' => 12,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 37,
                'page' => 'voucher_logs',
                'title' => 'Voucher Logs',
                'url' => 'reports/pg/voucher_logs',
                'module_id' => 7,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 39,
                'page' => 'search_traffic',
                'title' => 'Search Traffic',
                'url' => 'reports/pg/search_traffic',
                'module_id' => 7,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 40,
                'page' => 'set_url_redirect',
                'title' => 'Set URL Redirect',
                'url' => 'setup/set-url-redirect',
                'module_id' => 9,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],

            [
                'id' => 41,
                'page' => 'traffic_reports_csv',
                'title' => 'Traffic Reports CSV',
                'url' => 'reports/pg/traffic_reports_csv',
                'module_id' => 7,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 42,
                'page' => 'online_users_csv',
                'title' => 'Online Users CSV',
                'url' => 'reports/pg/online_users_csv',
                'module_id' => 7,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 43,
                'page' => 'traffic_reports',
                'title' => 'Traffic Reports',
                'url' => 'reports/pg/traffic_reports',
                'module_id' => 7,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 44,
                'page' => 'edit_hotel_room',
                'title' => 'Edit Hotel Room',
                'url' => 'clients/pg/edit_hotel_room',
                'module_id' => 12,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],

            [
                'id' => 45,
                'page' => 'hotel_rooms',
                'title' => 'Hotel Rooms',
                'url' => 'clients/pg/hotel_rooms',
                'module_id' => 13,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 46,
                'page' => 'add_hotel_room',
                'title' => 'Add Hotel Room',
                'url' => 'clients/pg/add_hotel_room',
                'module_id' => 13,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 47,
                'page' => 'list_ads',
                'title' => 'Ads - List',
                'url' => 'setup/ads/list-ads',
                'module_id' => 14,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 48,
                'page' => 'add_ad',
                'title' => 'Ads - Add',
                'url' => 'ads/pg/add_ad',
                'module_id' => 14,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],

            [
                'id' => 49,
                'page' => 'edit_ad',
                'title' => 'Ads - Edit',
                'url' => 'ads/pg/edit_ad',
                'module_id' => 14,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL,
            ],
            [
                'id' => 50,
                'page' => 'delete_ad',
                'title' => 'Ads - Delete',
                'url' => 'ads/pg/delete_ad',
                'module_id' => 14,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL,
            ],
            [
                'id' => 51,
                'page' => 'list_macs',
                'title' => 'List Bypassed Mac',
                'url' => 'clients/pg/list_macs',
                'module_id' => 15,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL,
            ],
            [
                'id' => 52,
                'page' => 'list_blocked_macs',
                'title' => 'List Blocked Mac',
                'url' => 'clients/pg/list_blocked_macs',
                'module_id' => 15,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL,
            ],
            [
                'id' => 53,
                'page' => 'add_mac',
                'title' => 'Add Mac Address',
                'url' => 'clients/pg/add_mac',
                'module_id' => 15,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL,
            ],
            [
                'id' => 54,
                'page' => 'edit_mac',
                'title' => 'Edit Mac',
                'url' => 'clients/pg/edit_mac',
                'module_id' => 15,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL,
            ],
            [
                'id' => 55,
                'page' => 'delete_mac',
                'title' => 'Delete Mac',
                'url' => 'clients/pg/delete_mac',
                'module_id' => 15,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL,
            ],
            [
                'id' => 56,
                'page' => 'find_users_data',
                'title' => 'Find Users Data',
                'url' => 'users_data/pg/find_users_data',
                'module_id' => 16,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL,
            ],
            [
                'id' => 57,
                'page' => 'users_data',
                'title' => 'Users Data',
                'url' => 'users_data/pg/view_users_data',
                'module_id' => 16,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL,
            ],
            [
                'id' => 58,
                'page' => 'print_users_data',
                'title' => 'Print Users Data',
                'url' => 'users_data/pg/print_users_data',
                'module_id' => 16,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 59,
                'page' => 'users_data_csv',
                'title' => 'Users Data CSV',
                'url' => 'users_data/pg/users_data_csv',
                'module_id' => 16,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 60,
                'page' => 'delete',
                'title' => 'Delete Users Data',
                'url' => 'users_data/pg/delete',
                'module_id' => 16,
                'allowed_groups' => '1',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 61,
                'page' => 'list_social_plugins',
                'title' => 'List Social Plugins',
                'url' => 'social_plugins/pg/list_social_plugins',
                'module_id' => 17,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 62,
                'page' => 'login_with_facebook',
                'title' => 'Login With Facebook',
                'url' => 'social_plugins/pg/login_with_facebook',
                'module_id' => 17,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 63,
                'page' => 'edit_fb_page',
                'title' => 'Edit Facebook Page',
                'url' => 'social_plugins/pg/edit_fb_page',
                'module_id' => 17,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 64,
                'page' => 'edit_fb_login_action',
                'title' => 'Edit Facebook Login Action',
                'url' => 'social_plugins/pg/edit_fb_login_action',
                'module_id' => 17,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 65,
                'page' => 'login_with_twitter',
                'title' => 'Login With Twitter',
                'url' => 'social_plugins/pg/login_with_twitter',
                'module_id' => 17,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 66,
                'page' => 'login_with_instagram',
                'title' => 'Login With Instagram',
                'url' => 'social_plugins/pg/login_with_instagram',
                'module_id' => 17,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 67,
                'page' => 'login_with_google',
                'title' => 'Login With Google',
                'url' => 'social_plugins/pg/login_with_google',
                'module_id' => 17,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            // NOT MEGALOS STANDAR IF PREMIUM SERVICES AND EDIT SERVICES ACTIVE 👇
            [
                'id' => 68,
                'page' => 'premium_services',
                'title' => 'Premium Services',
                'url' => 'services/premium-services',
                'module_id' => 4,
                'allowed_groups' => '1,2',
                'show_menu' => 1,
                'show_to' => 4
            ],
            [
                'id' => 69,
                'page' => 'edit_premium_service',
                'title' => 'Edit Premium Service',
                'url' => 'services/edit-premium-services',
                'module_id' => 4,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => 4
            ],
            [
                'id' => 70,
                'page' => 'create_premium_voucher_batch',
                'title' => 'Create Premium Voucher Batch',
                'url' => 'premium/pg/create_voucher_batch',
                'module_id' => 18,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 71,
                'page' => 'list_voucher_batches',
                'title' => 'List Premium Voucher Batches',
                'url' => 'premium/pg/list_voucher_batches',
                'module_id' => 18,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 72,
                'page' => 'list_active_vouchers',
                'title' => 'List Active Premium Vouchers',
                'url' => 'premium/pg/list_active_vouchers',
                'module_id' => 18,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 73,
                'page' => 'list_expired_vouchers',
                'title' => 'List Expired Premium Vouchers',
                'url' => 'premium/pg/list_expired_vouchers',
                'module_id' => 18,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 74,
                'page' => 'hotel_rooms_csv',
                'title' => 'Hotel Rooms CSV',
                'url' => 'client/pg/hotel_rooms_csv',
                'module_id' => 13,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 75,
                'page' => 'vouchers_print_setup',
                'title' => 'Vouchers Print Setup',
                'url' => 'setup/voucher-print-setup',
                'module_id' => 9,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 76,
                'page' => 'list_config',
                'title' => 'List Configs',
                'url' => '/setup/config/list-configs',
                'module_id' => 19,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => 19
            ],
            [
                'id' => 81,
                'page' => 'config_hotel_rooms',
                'title' => 'Config Hotel Rooms',
                'url' => '/setup/config/list-configs/hotel_rooms',
                'module_id' => 19,
                'allowed_groups' => '1',
                'show_menu' => 1,
                'show_to' => 19
            ],
            [
                'id' => 84,
                'page' => 'search_mac',
                'title' => 'Search Mac',
                'url' => 'clients/pg/search_mac',
                'module_id' => 15,
                'allowed_groups' => 1,
                'show_menu' => 1,
                'show_to' => NULL
            ],
            [
                'id' => 85,
                'page' => 'edit_all_static_hotel_rooms',
                'title' => 'Edit All Static Rooms',
                'url' => 'clients/pg/edit_all_static_hotel_rooms',
                'module_id' => 13,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 86,
                'page' => 'login_with_linkedin',
                'title' => 'Login With Linkedin',
                'url' => 'social_plugins/pg/login_with_linkedin',
                'module_id' => 17,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 87,
                'page' => 'batch_delete_macs',
                'title' => 'Batch Delete Macs',
                'url' => 'clients/pg/batch_delete_macs',
                'module_id' => 15,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ],
            [
                'id' => 88,
                'page' => 'batch_delete_clients',
                'title' => 'Batch Delete Clients',
                'url' => '#',
                'module_id' => 3,
                'allowed_groups' => '1,2',
                'show_menu' => 0,
                'show_to' => NULL
            ]
        ];

        foreach ($pages as $page) {
            Page::insert($page);
        }
    }
}
