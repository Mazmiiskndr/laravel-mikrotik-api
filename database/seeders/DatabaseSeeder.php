<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\RadAcct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(RadGroupReplySeeder::class);
        $this->call(ServicesSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(NasSeeder::class);
        $this->call(AdTypeSeeder::class);

        Admin::factory(50)->create();
        RadAcct::factory(50)->create();
    }
}
