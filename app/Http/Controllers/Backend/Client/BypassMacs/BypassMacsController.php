<?php

namespace App\Http\Controllers\Backend\Client\BypassMacs;

use App\Http\Controllers\Controller;
use App\Services\Client\BypassMacs\BypassMacsService;
use Illuminate\Http\Request;

class BypassMacsController extends Controller
{
    /**
     * @var BypassMacsService
     */
    protected $bypassMacsService;
    /**
     * Create a new BypassMacsController instance.
     * Middleware 'checkPermissions' is applied here to ensure only authorized users can access certain methods.
     * @param  VoucherService  $voucherService
     * @return void
     */
    public function __construct(BypassMacsService $bypassMacsService)
    {
        $this->bypassMacsService = $bypassMacsService;
        // Apply the 'checkPermissions' middleware to this controller with 'list-bypassed-mac' as the required permission
        $this->middleware('checkPermissions:list_macs,add_mac,edit_mac,delete_mac,batch_delete_macs')->only('bypassed');
        // Apply the 'checkPermissions' middleware to this controller with 'list-blocked-mac' as the required permission
        $this->middleware('checkPermissions:list_blocked_macs,add_mac,edit_mac,delete_mac,batch_delete_macs')->only('blocked');
    }

    /**
     * Display the list of list bypassed-mac.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     * This method retrieves permissions from the request's attributes,
     * set by 'checkPermissions' middleware, and returns a view with these permissions.
     */
    public function bypassed(Request $request)
    {
        // Retrieve the permissions from the request's attributes which were set in the 'checkPermissions' middleware
        $permissions = $request->attributes->get('permissions');
        // Return the view with the permissions.
        return view('backend.clients.bypass-macs.list-bypassed-macs', compact('permissions'));
    }

    /**
     * Display the list of list blocked-mac.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     * This method retrieves permissions from the request's attributes,
     * set by 'checkPermissions' middleware, and returns a view with these permissions.
     */
    public function blocked(Request $request)
    {
        // Retrieve the permissions from the request's attributes which were set in the 'checkPermissions' middleware
        $permissions = $request->attributes->get('permissions');
        // Return the view with the permissions.
        return view('backend.clients.bypass-macs.list-blocked-macs', compact('permissions'));
    }
}
