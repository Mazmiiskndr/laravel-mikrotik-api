<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['id' => 1, 'module_id' => 3, 'setting' => 'clients_vouchers_printer', 'value' => 'double_column_voucher_printer', 'flag_module' => 'clients'],
            ['id' => 2, 'module_id' => 3, 'setting' => 'create_vouchers_type', 'value' => 'with_password', 'flag_module' => 'clients'],
            ['id' => 3, 'module_id' => 4, 'setting' => 'url_redirect', 'value' => 'https://github.com/Mazmiiskndr', 'flag_module' => NULL],
            ['id' => 4, 'module_id' => 13, 'setting' => 'hms_connect', 'value' => '1', 'flag_module' => 'hotel_rooms'],
            ['id' => 5, 'module_id' => 14, 'setting' => 'ads_max_width', 'value' => '160', 'flag_module' => 'ads'],
            ['id' => 6, 'module_id' => 14, 'setting' => 'ads_max_height', 'value' => '390', 'flag_module' => 'ads'],
            ['id' => 7, 'module_id' => 14, 'setting' => 'ads_max_size', 'value' => '400', 'flag_module' => 'ads'],
            ['id' => 8, 'module_id' => 14, 'setting' => 'ads_upload_folder', 'value' => 'files', 'flag_module' => 'ads'],
            ['id' => 9, 'module_id' => 14, 'setting' => 'ads_thumb_width', 'value' => '80', 'flag_module' => 'ads'],
            ['id' => 10, 'module_id' => 14, 'setting' => 'ads_thumb_height', 'value' => '80', 'flag_module' => 'ads'],
            ['id' => 11, 'module_id' => 15, 'setting' => 'mac_default_password', 'value' => '123456', 'flag_module' => NULL],
            ['id' => 12, 'module_id' => 15, 'setting' => 'mac_default_mikrotik_group', 'value' => 'mac_profile', 'flag_module' => NULL],
            ['id' => 13, 'module_id' => 16, 'setting' => 'id_column', 'value' => '0', 'flag_module' => 'users_data'],
            ['id' => 14, 'module_id' => 16, 'setting' => 'name_column', 'value' => '1', 'flag_module' => 'users_data'],
            ['id' => 15, 'module_id' => 16, 'setting' => 'email_column', 'value' => '1', 'flag_module' => 'users_data'],
            ['id' => 16, 'module_id' => 16, 'setting' => 'phone_number_column', 'value' => '0', 'flag_module' => 'users_data'],
            ['id' => 17, 'module_id' => 16, 'setting' => 'room_number_column', 'value' => '1', 'flag_module' => 'users_data'],
            ['id' => 18, 'module_id' => 16, 'setting' => 'date_column', 'value' => '1', 'flag_module' => 'users_data'],
            ['id' => 19, 'module_id' => 16, 'setting' => 'first_name_column', 'value' => '0', 'flag_module' => 'users_data'],
            ['id' => 20, 'module_id' => 16, 'setting' => 'last_name_column', 'value' => '0', 'flag_module' => 'users_data'],
            ['id' => 21, 'module_id' => 16, 'setting' => 'mac_column', 'value' => '0', 'flag_module' => 'users_data'],
            ['id' => 22, 'module_id' => 16, 'setting' => 'location_column', 'value' => '0', 'flag_module' => 'users_data'],
            ['id' => 23, 'module_id' => 16, 'setting' => 'gender_column', 'value' => '0', 'flag_module' => 'users_data'],
            ['id' => 24, 'module_id' => 16, 'setting' => 'birthday_column', 'value' => '0', 'flag_module' => 'users_data'],
            ['id' => 25, 'module_id' => 16, 'setting' => 'login_with_column', 'value' => '0', 'flag_module' => 'users_data'],
            ['id' => 26, 'module_id' => 16, 'setting' => 'display_id', 'value' => 'ID', 'flag_module' => 'users_data'],
            ['id' => 27, 'module_id' => 16, 'setting' => 'display_name', 'value' => 'Guest Name', 'flag_module' => 'users_data'],
            ['id' => 28, 'module_id' => 16, 'setting' => 'display_email', 'value' => 'Email Address', 'flag_module' => 'users_data'],
            ['id' => 29, 'module_id' => 16, 'setting' => 'display_phone_number', 'value' => 'Phone Number', 'flag_module' => 'users_data'],
            ['id' => 30, 'module_id' => 16, 'setting' => 'display_room_number', 'value' => 'Room Number', 'flag_module' => 'users_data'],
            ['id' => 31, 'module_id' => 16, 'setting' => 'display_date', 'value' => 'Input Date', 'flag_module' => 'users_data'],
            ['id' => 32, 'module_id' => 16, 'setting' => 'display_first_name', 'value' => 'First Name', 'flag_module' => 'users_data'],
            ['id' => 33, 'module_id' => 16, 'setting' => 'display_last_name', 'value' => 'Last Name', 'flag_module' => 'users_data'],
            ['id' => 34, 'module_id' => 16, 'setting' => 'display_mac', 'value' => 'Mac Address', 'flag_module' => 'users_data'],
            ['id' => 35, 'module_id' => 16, 'setting' => 'display_location', 'value' => 'Location', 'flag_module' => 'users_data'],
            ['id' => 36, 'module_id' => 16, 'setting' => 'display_gender', 'value' => 'Gender', 'flag_module' => 'users_data'],
            ['id' => 37, 'module_id' => 16, 'setting' => 'display_birthday', 'value' => 'Birthday', 'flag_module' => 'users_data'],
            ['id' => 38, 'module_id' => 16, 'setting' => 'display_login_with', 'value' => 'Login With', 'flag_module' => 'users_data'],
            ['id' => 39, 'module_id' => 17, 'setting' => 'fb_login_action', 'value' => 'Login', 'flag_module' => NULL],
            ['id' => 40, 'module_id' => 17, 'setting' => 'fb_page', 'value' => NULL, 'flag_module' => NULL],
            ['id' => 41, 'module_id' => 17, 'setting' => 'fb_page_id', 'value' => NULL, 'flag_module' => NULL],
            ['id' => 42, 'module_id' => 17, 'setting' => 'fb_service_id', 'value' => NULL, 'flag_module' => NULL],
            ['id' => 43, 'module_id' => 17, 'setting' => 'fb_page_name', 'value' => 'Hotspot Page', 'flag_module' => NULL],
            ['id' => 44, 'module_id' => 17, 'setting' => 'fb_app_id', 'value' => 'social_plugins', 'flag_module' => NULL],
            ['id' => 45, 'module_id' => 17, 'setting' => 'fb_app_secret', 'value' => 'social_plugins', 'flag_module' => NULL],
            ['id' => 46, 'module_id' => 17, 'setting' => 'tw_login_action', 'value' => 'Login', 'flag_module' => NULL],
            ['id' => 47, 'module_id' => 17, 'setting' => 'tw_api_key', 'value' => 'social_plugins', 'flag_module' => NULL],
            ['id' => 48, 'module_id' => 17, 'setting' => 'tw_api_secret', 'value' => 'social_plugins', 'flag_module' => NULL],
            ['id' => 49, 'module_id' => 17, 'setting' => 'tw_status_update', 'value' => NULL, 'flag_module' => NULL],
            ['id' => 50, 'module_id' => 17, 'setting' => 'tw_service_id', 'value' => NULL, 'flag_module' => NULL],
            ['id' => 51, 'module_id' => 17, 'setting' => 'tw_username', 'value' => NULL, 'flag_module' => NULL],
            ['id' => 56, 'module_id' => 17, 'setting' => 'google_login_action', 'value' => 'Login', 'flag_module' => NULL],
            ['id' => 57, 'module_id' => 17, 'setting' => 'google_service_id', 'value' => NULL, 'flag_module' => NULL],
            ['id' => 58, 'module_id' => 17, 'setting' => 'google_api_client_id', 'value' => 'social_plugins', 'flag_module' => NULL],
            ['id' => 59, 'module_id' => 17, 'setting' => 'login_with_facebook_on', 'value' => '1', 'flag_module' => 'social_plugins'],
            ['id' => 60, 'module_id' => 17, 'setting' => 'login_with_twitter_on', 'value' => '0', 'flag_module' => 'social_plugins'],
            ['id' => 62, 'module_id' => 17, 'setting' => 'login_with_google_on', 'value' => '0', 'flag_module' => 'social_plugins'],
            ['id' => 63, 'module_id' => 18, 'setting' => 'varnion_notification', 'value' => 'premium', 'flag_module' => NULL],
            ['id' => 64, 'module_id' => 18, 'setting' => 'hotel_name', 'value' => 'premium', 'flag_module' => NULL],
            ['id' => 65, 'module_id' => 14, 'setting' => 'mobile_ads_max_width', 'value' => '160', 'flag_module' => 'ads'],
            ['id' => 66, 'module_id' => 14, 'setting' => 'mobile_ads_max_height', 'value' => '390', 'flag_module' => 'ads'],
            ['id' => 67, 'module_id' => 14, 'setting' => 'mobile_ads_max_size', 'value' => '400', 'flag_module' => 'ads'],
            ['id' => 71, 'module_id' => 3, 'setting' => 'how_to_use_voucher', 'value' => 'Turn on wifi,Open internet browser,Input username password', 'flag_module' => NULL],
            ['id' => 72, 'module_id' => 3, 'setting' => 'voucher_logo_filename', 'value' => NULL, 'flag_module' => NULL],
            ['id' => 73, 'module_id' => 0, 'setting' => 'mikrotik_ip', 'value' => NULL, 'flag_module' => NULL],
            ['id' => 74, 'module_id' => 0, 'setting' => 'mikrotik_api_port', 'value' => '8728', 'flag_module' => NULL],
            ['id' => 75, 'module_id' => 0, 'setting' => 'mikrotik_api_username', 'value' => 'admin', 'flag_module' => NULL],
            ['id' => 76, 'module_id' => 0, 'setting' => 'mikrotik_api_password', 'value' => 'megalos', 'flag_module' => NULL],
            ['id' => 77, 'module_id' => 0, 'setting' => 'server_ip', 'value' => NULL, 'flag_module' => NULL],
            ['id' => 78, 'module_id' => 17, 'setting' => 'google_api_client_secret', 'value' => 'social_plugins', 'flag_module' => NULL],
            ['id' => 79, 'module_id' => 17, 'setting' => 'login_with_linkedin_on', 'value' => '0', 'flag_module' => 'social_plugins'],
            ['id' => 80, 'module_id' => 17, 'setting' => 'linkedin_login_action', 'value' => 'Login', 'flag_module' => NULL],
            ['id' => 81, 'module_id' => 17, 'setting' => 'linkedin_service_id', 'value' => NULL, 'flag_module' => NULL],
            ['id' => 82, 'module_id' => 17, 'setting' => 'linkedin_api_client_id', 'value' => 'social_plugins', 'flag_module' => NULL],
            ['id' => 83, 'module_id' => 17, 'setting' => 'linkedin_api_client_secret', 'value' => 'social_plugins', 'flag_module' => NULL],
            ['id' => 84, 'module_id' => 0, 'setting' => 'log_activities', 'value' => 1, 'flag_module' => NULL],
        ];

        foreach ($settings as $setting) {
            Setting::insert($setting);
        }
    }
}





