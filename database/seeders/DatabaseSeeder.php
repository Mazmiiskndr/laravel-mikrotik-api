<?php

namespace Database\Seeders;

use App\Models\Admin;
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
        $this->call(AdminSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(RadGroupReplySeeder::class);
        $this->call(ServicesSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(SettingSeeder::class);

        Admin::factory(50)->create();
    }
}
