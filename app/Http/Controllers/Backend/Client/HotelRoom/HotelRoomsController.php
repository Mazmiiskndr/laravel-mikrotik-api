<?php

namespace App\Http\Controllers\Backend\Client\HotelRoom;

use App\Http\Controllers\Controller;
use App\Services\Client\HotelRoom\HotelRoomService;
use Illuminate\Http\Request;

class HotelRoomsController extends Controller
{
    /**
     * @var HotelRoomService
     */
    protected $hotelRoomService;
    /**
     * Create a new VoucherBatchController instance.
     * Middleware 'checkPermissions' is applied here to ensure only authorized users can access certain methods.
     * @param  VoucherService  $voucherService
     * @return void
     */
    public function __construct(HotelRoomService $hotelRoomService)
    {
        $this->hotelRoomService = $hotelRoomService;
        // Apply the 'checkPermissions' middleware to this controller with 'users-data' as the required permission
        $this->middleware('checkPermissions:hotel_rooms,edit_hotel_room')->only('index');
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
        return view('backend.clients.hotel-rooms.list-hotel-rooms', compact('permissions'));
    }
}
