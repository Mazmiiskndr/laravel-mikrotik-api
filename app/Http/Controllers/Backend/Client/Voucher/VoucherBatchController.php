<?php

namespace App\Http\Controllers\Backend\Client\Voucher;

use App\Http\Controllers\Controller;
use App\Services\Client\Voucher\VoucherService;
use Illuminate\Http\Request;

class VoucherBatchController extends Controller
{
    /**
     * Create a new controller instance.
     * Middleware 'checkPermissions' is applied here to ensure only authorized users can access certain methods.
     * @return void
     */
    public function __construct()
    {
        // Apply the 'checkPermissions' middleware to this controller with 'voucher-batches' as the required permission
        $this->middleware('checkPermissions:list_voucher_batches,create_voucher_batch,delete_voucher_batch,delete_voucher_batches')->only('index');
    }

    /**
     * Display the list of list voucher-batches.
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
        return view('backend.clients.vouchers.list-voucher-bathes', compact('permissions'));
    }

    /**
     * Show the datatable for detail a voucher batch.
     * @param  int  $voucherBatchId
     */
    public function show($voucherBatchId)
    {
        // Return the view with the permissions and dataVouchers.
        return view('backend.clients.vouchers.voucher-batch-detail', compact('voucherBatchId'));
    }
}
