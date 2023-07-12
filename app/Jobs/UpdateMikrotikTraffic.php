<?php

namespace App\Jobs;

use App\Helpers\MikrotikConfigHelper;
use App\Services\MikrotikApi\MikrotikApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class UpdateMikrotikTraffic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MikrotikApiService $mikrotikApiService)
    {
        // Retrieve the Mikrotik configuration settings.
        $config = MikrotikConfigHelper::getMikrotikConfig();

        // Check if the configuration exists and no values are empty.
        if ($config && !in_array("", $config, true)) {

            // Try to retrieve Mikrotik resource data using Mikrotik API service. On exception, set data to null.
            try {
                // Retrieve data traffic from Mikrotik router using Mikrotik API Curl service.
                $data = $mikrotikApiService->getTrafficData($config['ip'], $config['username'], $config['password'], env('MIKROTIK_INTERFACE'));
            } catch (\Exception $e) {
                $data = [
                    'uploadTraffic' => 0,
                    'downloadTraffic' => 0,
                ];
            }

            // Assign the retrieved data to respective variables. Use default values if the data is not available.
            $upload = intval($data['uploadTraffic']) ?? 0;
            $download = intval($data['downloadTraffic']) ?? 0;


            // Store data in cache for multiple data retrievals
            Cache::put('mikrotik.uploadTraffic', $upload, 2);
            Cache::put('mikrotik.downloadTraffic', $download, 2);
        }
    }
}
