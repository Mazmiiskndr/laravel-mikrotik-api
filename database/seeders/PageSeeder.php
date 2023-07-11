<?php

namespace Database\Seeders;

class PageSeeder
{
    public static function getPages($old_id): array|bool
    {
        if ($old_id) {
            # code...
            $pages = [
                [2, 'index', 'Main Homepage', 'home', '1,2', 1, NULL],
                [3, 'list_clients', 'List Clients', 'clients/list-clients', '1,2', 1, NULL],
                [3, 'batch_delete_clients', 'Batch Delete Clients', '#', '1,2', 0, NULL],
                [3, 'delete_client', 'Delete Client', '#', '1,2', 0, NULL],
                [3, 'edit_client', 'Edit Client', '#', '1,2', 0, NULL],
                [3, 'add_new_client', 'Add New Client', '#', '1,2', 0, NULL],
                [4, 'list_services', 'List Services', 'services/list-services', '1,2', 1, NULL],
                [4, 'add_new_service', 'Add New Service', 'services/add-new-service', '1,2', 1, NULL],
                // *** ⚠️👇 PREMIUM SERVICES IS NOT MEGALOS STANDAR 👇⚠️***
                [4, 'premium_services', 'Premium Services', 'services/premium-services', '1,2', 1, 4],
                [4, 'edit_premium_service', 'Edit Premium Service', 'services/edit-premium-services', '1,2', 0, 4],
                // *** ⚠️👆 PREMIUM SERVICES IS NOT MEGALOS STANDAR 👆⚠️***
                [4, 'edit_service', 'Edit Service', 'services/edit-service', '1,2', 0, NULL],
                [4, 'delete_service', 'Delete Service', 'services/pg/delete_service', '1', 0, NULL],
                [7, 'traffic_reports', 'Traffic Reports', 'reports/pg/traffic_reports', '1', 0, NULL],
                [7, 'online_users_csv', 'Online Users CSV', 'reports/pg/online_users_csv', '1', 0, NULL],
                [7, 'traffic_reports_csv', 'Traffic Reports CSV', 'reports/pg/traffic_reports_csv', '1', 0, NULL],
                [7, 'list_online_users', 'List Online Users', 'reports/list-online-users', '1,2', 1, NULL],
                [7, 'voucher_logs', 'Voucher Logs', 'reports/pg/voucher_logs', '1', 1, NULL],
                [7, 'search_traffic', 'Search Traffic', 'reports/pg/search_traffic', '1', 0, NULL],
                [9, 'set_url_redirect', 'Set URL Redirect', 'setup/set-url-redirect', '1,2', 1, NULL],
                [9, 'vouchers_print_setup', 'Vouchers Print Setup', 'setup/voucher-print-setup', '1', 1, NULL],
                [10, 'list_admins', 'List Admins', 'setup/admin/list-admins', '1', 1, NULL],
                [10, 'add_new_admin', 'Add New Admin', '#', '1', 0, NULL],
                [10, 'list_groups', 'List Groups', 'setup/admin/list-groups', '1', 1, NULL],
                [10, 'add_new_group', 'Add New Group', 'setup/admin/add-new-group', '1', 1, NULL],
                [10, 'edit_admin', 'Edit Admin', '#', '1', 0, NULL],
                [10, 'delete_group', 'Delete Group', 'administrators/pg/delete_group', '1', 0, NULL],
                [10, 'delete_admin', 'Delete Admin', '#', '1', 0, NULL],
                [10, 'edit_group', 'Edit Group', 'setup/admin/edit-group', '1', 0, NULL],
                [12, 'delete_voucher_batches', 'Delete Voucher Batches', '#', '1,2', 0, NULL],
                [12, 'delete_voucher_batch', 'Delete Voucher Batch', '#', '1,2', 0, NULL],
                [12, 'list_voucher_batches', 'List Voucher Batches', 'clients/voucher/list-voucher-batches', '1,2', 1, NULL],
                [12, 'create_voucher_batch', 'Create Voucher Batch', '#', '1,2', 0, NULL],
                [12, 'list_active_vouchers', 'List Active Vouchers', 'clients/voucher/list-active-vouchers', '1,2', 1, NULL],
                [13, 'hotel_rooms', 'Hotel Rooms', 'clients/hotel-rooms', '1,2', 1, NULL],
                [12, 'edit_hotel_room', 'Edit Hotel Room', 'clients/pg/edit_hotel_room', '1,2', 0, NULL],
                [13, 'hotel_rooms_csv', 'Hotel Rooms CSV', '#', '1,2', 0, NULL],
                [13, 'print_hotel_rooms', 'Print Hotel Rooms', '#', '1,2', 0, NULL],
                [13, 'edit_all_static_hotel_rooms', 'Edit All Static Rooms', 'clients/pg/edit_all_static_hotel_rooms', '1,2', 0, NULL],
                [13, 'add_hotel_room', 'Add Hotel Room', 'clients/pg/add_hotel_room', '1,2', 0, NULL],
                [14, 'list_ads', 'Ads - List', 'setup/ads/list-ads', '1,2', 1, NULL],
                [14, 'add_ad', 'Ads - Add', 'ads/pg/add_ad', '1,2', 0, NULL],
                [14, 'edit_ad', 'Ads - Edit', 'ads/pg/edit_ad', '1,2', 0, NULL],
                [14, 'delete_ad', 'Ads - Delete', 'ads/pg/delete_ad', '1,2', 0, NULL],
                [15, 'list_macs', 'List Bypassed Mac', 'clients/list-bypassed-macs', '1', 1, NULL],
                [15, 'list_blocked_macs', 'List Blocked Mac', 'clients/list-blocked-macs', '1', 1, NULL],
                [15, 'batch_delete_macs', 'Batch Delete Macs', '#', '1,2', 0, NULL],
                [15, 'add_mac', 'Add Mac Address', 'clients/pg/add_mac', '1', 1, NULL],
                [15, 'search_mac', 'Search Mac', 'clients/pg/search_mac', '1', 1, NULL],
                [15, 'edit_mac', 'Edit Mac', 'clients/pg/edit_mac', '1', 0, NULL],
                [15, 'delete_mac', 'Delete Mac', 'clients/pg/delete_mac', '1', 0, NULL],
                [16, 'users_data', 'Users Data', 'clients/users-data', '1', 1, NULL],
                [16, 'find_users_data', 'Find Users Data', '#', '1', 0, NULL],
                [16, 'delete_users_data', 'Delete Users Data', 'users_data/pg/delete', '1', 0, NULL],
                [16, 'users_data_csv', 'Users Data CSV', '#', '1', 0, NULL],
                [16, 'print_users_data', 'Print Users Data', '#', '1', 0, NULL],
                [17, 'login_with_facebook', 'Login With Facebook', 'social_plugins/pg/login_with_facebook', '1,2', 0, NULL],
                [17, 'login_with_linkedin', 'Login With Linkedin', 'social_plugins/pg/login_with_linkedin', '1,2', 0, NULL],
                [17, 'login_with_google', 'Login With Google', 'social_plugins/pg/login_with_google', '1,2', 0, NULL],
                [17, 'login_with_instagram', 'Login With Instagram', 'social_plugins/pg/login_with_instagram', '1,2', 0, NULL],
                [17, 'login_with_twitter', 'Login With Twitter', 'social_plugins/pg/login_with_twitter', '1,2', 0, NULL],
                [17, 'edit_fb_login_action', 'Edit Facebook Login Action', 'social_plugins/pg/edit_fb_login_action', '1,2', 0, NULL],
                [17, 'edit_fb_page', 'Edit Facebook Page', 'social_plugins/pg/edit_fb_page', '1,2', 0, NULL],
                [17, 'list_social_plugins', 'List Social Plugins', 'social_plugins/pg/list_social_plugins', '1,2', 1, NULL],
                [18, 'list_voucher_batches', 'List Premium Voucher Batches', 'premium/pg/list_voucher_batches', '1', 1, NULL],
                [18, 'list_active_vouchers', 'List Active Premium Vouchers', 'premium/pg/list_active_vouchers', '1', 1, NULL],
                [18, 'list_expired_vouchers', 'List Expired Premium Vouchers', 'premium/pg/list_expired_vouchers', '1', 1, NULL],
                [18, 'create_premium_voucher_batch', 'Create Premium Voucher Batch', 'premium/pg/create_voucher_batch', '1', 1, NULL],
                [19, 'list_config', 'List Configs', '/setup/config/list-configs', '1', 1, 19],
                [19, 'config_hotel_rooms', 'Config Hotel Rooms', '/setup/config/list-configs/hotel_rooms', '1', 1, 19]
            ];

            $newPages = [];

            foreach ($pages as $page) {
                # code...
                if ($old_id == $page[0]) {
                    # code...
                    $newPages[] = [
                        'page' => $page[1],
                        'title' => $page[2],
                        'url' => $page[3],
                        'allowed_groups' => $page[4],
                        'show_menu' => $page[5],
                        'show_to' => $page[6],
                    ];
                }
            }

            return $newPages;
        }

        return false;
    }
}
