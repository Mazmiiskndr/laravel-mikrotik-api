<?php

namespace Database\Seeders;

use App\Models\AdType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adsType = [
            [
                'name' => 'banner',
                'title' => 'Banner',
                'max_height' => 0,
                'max_width' => 0,
                'max_size' => 0,
                'mobile_max_height' => 0,
                'mobile_max_width' => 0,
                'mobile_max_size' => 0,
                'single_image' => 0
            ],
        ];

        foreach ($adsType as $adTypeData) {
            $admin = new AdType();
            $admin->name = $adTypeData['name'];
            $admin->title = $adTypeData['title'];
            $admin->max_height = $adTypeData['max_height'];
            $admin->max_width = $adTypeData['max_width'];
            $admin->max_size = $adTypeData['max_size'];
            $admin->mobile_max_height = $adTypeData['mobile_max_height'];
            $admin->mobile_max_width = $adTypeData['mobile_max_width'];
            $admin->mobile_max_size = $adTypeData['mobile_max_size'];
            $admin->single_image = $adTypeData['single_image'];
            $admin->save();
        }
    }
}
