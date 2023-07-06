<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public static function getSetting($old_id): array|bool
    {
        if ($old_id) {
            # code...
            $array = [
                ['default', 'log_activities', '1', 'default'],
                ['default', 'server_ip', NULL, 'default'],
                ['default', 'mikrotik_api_password', 'megalos', 'default'],
                ['default', 'mikrotik_api_username', 'admin', 'default'],
                ['default', 'mikrotik_api_port', '8728', 'default'],
                ['default', 'mikrotik_ip', NULL, 'default'],
                [3, 'create_vouchers_type', 'with_password', 'clients'],
                [3, 'voucher_logo_filename', NULL, NULL],
                [3, 'how_to_use_voucher', 'Turn on wifi,Open internet browser,Input username password', NULL],
                [3, 'clients_vouchers_printer', 'double_column_voucher_printer', 'clients'],
                [4, 'url_redirect', 'https://github.com/Mazmiiskndr', NULL],
                [13, 'hms_connect', '1', 'hotel_rooms'],
                [14, 'ads_thumb_height', '80', 'ads'],
                [14, 'ads_max_width', '160', 'ads'],
                [14, 'ads_max_height', '390', 'ads'],
                [14, 'ads_max_size', '400', 'ads'],
                [14, 'ads_upload_folder', 'files', 'ads'],
                [14, 'ads_thumb_width', '80', 'ads'],
                [14, 'mobile_ads_max_size', '400', 'ads'],
                [14, 'mobile_ads_max_height', '390', 'ads'],
                [14, 'mobile_ads_max_width', '160', 'ads'],
                [15, 'mac_default_password', '123456', NULL],
                [15, 'mac_default_mikrotik_group', 'mac_profile', NULL],
                [16, 'birthday_column', '0', 'users_data'],
                [16, 'id_column', '0', 'users_data'],
                [16, 'name_column', '1', 'users_data'],
                [16, 'email_column', '1', 'users_data'],
                [16, 'phone_number_column', '0', 'users_data'],
                [16, 'room_number_column', '1', 'users_data'],
                [16, 'date_column', '1', 'users_data'],
                [16, 'first_name_column', '0', 'users_data'],
                [16, 'last_name_column', '0', 'users_data'],
                [16, 'mac_column', '0', 'users_data'],
                [16, 'location_column', '0', 'users_data'],
                [16, 'display_login_with', 'Login With', 'users_data'],
                [16, 'display_birthday', 'Birthday', 'users_data'],
                [16, 'display_location', 'Location', 'users_data'],
                [16, 'gender_column', '0', 'users_data'],
                [16, 'login_with_column', '0', 'users_data'],
                [16, 'display_id', 'ID', 'users_data'],
                [16, 'display_name', 'Guest Name', 'users_data'],
                [16, 'display_email', 'Email Address', 'users_data'],
                [16, 'display_phone_number', 'Phone Number', 'users_data'],
                [16, 'display_room_number', 'Room Number', 'users_data'],
                [16, 'display_date', 'Input Date', 'users_data'],
                [16, 'display_first_name', 'First Name', 'users_data'],
                [16, 'display_last_name', 'Last Name', 'users_data'],
                [16, 'display_mac', 'Mac Address', 'users_data'],
                [16, 'display_gender', 'Gender', 'users_data'],
                [17, 'fb_app_secret', 'social_plugins', NULL],
                [17, 'linkedin_api_client_secret', 'social_plugins', NULL],
                [17, 'linkedin_api_client_id', 'social_plugins', NULL],
                [17, 'linkedin_service_id', NULL, NULL],
                [17, 'linkedin_login_action', 'Login', NULL],
                [17, 'login_with_linkedin_on', '0', 'social_plugins'],
                [17, 'google_api_client_secret', 'social_plugins', NULL],
                [17, 'fb_login_action', 'Login', NULL],
                [17, 'fb_page', NULL, NULL],
                [17, 'fb_page_id', NULL, NULL],
                [17, 'fb_service_id', NULL, NULL],
                [17, 'fb_page_name', 'Hotspot Page', NULL],
                [17, 'fb_app_id', 'social_plugins', NULL],
                [17, 'tw_status_update', NULL, NULL],
                [17, 'tw_login_action', 'Login', NULL],
                [17, 'tw_api_key', 'social_plugins', NULL],
                [17, 'tw_api_secret', 'social_plugins', NULL],
                [17, 'login_with_google_on', '0', 'social_plugins'],
                [17, 'login_with_twitter_on', '0', 'social_plugins'],
                [17, 'login_with_facebook_on', '1', 'social_plugins'],
                [17, 'google_api_client_id', 'social_plugins', NULL],
                [17, 'google_service_id', NULL, NULL],
                [17, 'google_login_action', 'Login', NULL],
                [17, 'tw_username', NULL, NULL],
                [17, 'tw_service_id', NULL, NULL],
                [18, 'hotel_name', 'premium', NULL],
                [18, 'varnion_notification', 'premium', NULL],
            ];

            $newArray = [];

            foreach ($array as $key => $value) {
                # code...
                if ($old_id == $value[0]) {
                    # code...
                    $newArray[] = [
                        'setting' => $value[1],
                        'value' => $value[2],
                        'flag_module' => $value[3],
                    ];
                }
            }

            return $newArray;
        }

        return false;
    }
}
