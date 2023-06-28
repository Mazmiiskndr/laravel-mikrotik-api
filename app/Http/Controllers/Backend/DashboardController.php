<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\AccessControlHelper;
use App\Http\Controllers\Controller;
use App\Helpers\MikrotikConfigHelper;
use App\Services\Nas\NasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Check if the user is allowed to see Statistics
        $isAllowedToAdministrator = AccessControlHelper::isAllowedAdministrator();
        return view('backend.dashboard.index', [
            'isAllowedToAdministrator' => $isAllowedToAdministrator
        ]);
    }


}
