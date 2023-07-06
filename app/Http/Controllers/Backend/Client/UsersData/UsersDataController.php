<?php

namespace App\Http\Controllers\Backend\Client\UsersData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersDataController extends Controller
{
    /**
     * Create a new controller instance.
     * Middleware 'checkPermissions' is applied here to ensure only authorized users can access certain methods.
     * @return void
     */
    public function __construct()
    {
        // Apply the 'checkPermissions' middleware to this controller with 'users-data' as the required permission
        $this->middleware('checkPermissions:users_data,find_users_data,delete_users_data,users_data_csv,print_users_data')->only('index');
    }

    /**
     * Display the list of list users-data.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     * This method retrieves permissions from the request's attributes,
     * set by 'checkPermissions' middleware, and returns a view with these permissions.
     */
    public function index(Request $request)
    {
        // Retrieve the permissions from the request's attributes which were set in the 'checkPermissions' middleware
        $permissions = $request->attributes->get('permissions');
        // Return the view with the permissions.
        return view('backend.clients.users-data.list-users-data', compact('permissions'));
    }
}
