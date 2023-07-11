<?php

namespace App\Http\Controllers\Backend\Client\UserData;

use App\Http\Controllers\Controller;
use App\Services\Client\UsersData\UsersDataService;
use Illuminate\Http\Request;
use PDF;

class UsersDataController extends Controller
{
    /**
     * @var UsersDataService
     */
    protected $usersDataService;
    /**
     * Create a new VoucherBatchController instance.
     * Middleware 'checkPermissions' is applied here to ensure only authorized users can access certain methods.
     * @param  VoucherService  $voucherService
     * @return void
     */
    public function __construct(UsersDataService $usersDataService)
    {
        $this->usersDataService = $usersDataService;
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

    /**
     * Exports a report of users data to a PDF file.
     * @param UsersDataService $usersDataService Service to generate report data.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse PDF file download response.
     */
    public function print()
    {
        // Load a view file named 'print-users-data' which is located under the 'backend.clients.users-data' directory.
        $pdf = PDF::loadView('backend.clients.users-data.print-users-data', [
            'users' => $this->usersDataService->getUsersData(null, ['id', 'date', 'name', 'email', 'room_number'],null)['data']
        ]);

        // Set the paper size for the PDF to 'A4' and the orientation to 'landscape' to achieve a wider format.
        $pdf->setPaper('A4', 'landscape');

        // Stream the PDF to the browser for download with a filename that includes today's date.
        return $pdf->stream('users-data-' . date('Y-m-d') . '.pdf');
    }
}
