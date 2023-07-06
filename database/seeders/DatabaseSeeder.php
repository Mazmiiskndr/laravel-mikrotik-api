<?php

namespace Database\Seeders;

use App\Models\RadAcct;
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
        // $this->call(GroupSeeder::class);
        // $this->call(SettingSeeder::class);
        // $this->call(PageSeeder::class);dass
        RadAcct::factory(50)->create();
        $this->call([
            AdminSeeder::class,
            RadGroupReplySeeder::class,
            ServicesSeeder::class,
            ModuleSeeder::class,
            NasSeeder::class,
            AdTypeSeeder::class,
        ]);
    }
}
