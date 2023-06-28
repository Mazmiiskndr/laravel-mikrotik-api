<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListOnlineUserController extends Controller
{
    /**
     * UserController constructor.
     * Apply appropriate permissions for each method in the controller.
     */
    public function __construct()
    {
        // Apply permissions middleware to each method as required.
        $this->middleware('checkPermissions:list_online_users')->only('index');
    }

    /**
     * Handle a request to show the list of `list-online-users`.
     * @param Request $request Current request instance.
     * @return \Illuminate\View\View The `list-online-users` list view.
     */
    public function index(Request $request)
    {
        // Retrieve the permissions from the request's attributes which were set in the 'checkPermissions' middleware
        $permissions = $request->attributes->get('permissions');
        // Return the view with the permissions.
        return view('backend.reports.list-online-users', compact('permissions'));
    }
}
