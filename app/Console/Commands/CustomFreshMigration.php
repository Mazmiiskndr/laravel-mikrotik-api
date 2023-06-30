<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CustomFreshMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:customfresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custom fresh migration that ignores freeradius tables';

    /**
     * List of tables to ignore.
     * Add your FreeRADIUS tables here.
     *
     * @var array
     */
    protected $ignoreTables = [
        'radacct',
        'radcheck',
        'radgroupcheck',
        'radgroupreply',
        'radreply',
        'radusergroup',
        'nas'
        // add more tables here if needed...
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Get the list of all table names.
        $tableNames = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        // Filter out the ignored tables.
        $tablesToDrop = array_diff($tableNames, $this->ignoreTables);

        // Drop all tables except the ignored ones.
        foreach ($tablesToDrop as $tableName) {
            Schema::dropIfExists($tableName);
        }

        // Run the migrations.
        $this->call('migrate', ['--force' => true]);

        // Run the seeders.
        $this->call('db:seed', ['--force' => true]);
        // Add your custom message here
        $this->info('Migration and seeding with ignore freeradius tables successful.');
        $this->info('*** Created by ' . config('variables.creatorName') ?? "PT. Varnion Technology Semesta" . ' ***');
    }
}
