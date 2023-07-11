<?php

namespace App\Http\Controllers\Backend\Client\HotelRoom;

use App\Http\Controllers\Controller;
use App\Services\Client\HotelRoom\HotelRoomService;
use Illuminate\Http\Request;
use PDF;

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
        // Apply the 'checkPermissions' middleware to this controller with 'hotel-rooms' as the required permission
        $this->middleware('checkPermissions:hotel_rooms,edit_hotel_room,print_hotel_rooms,hotel_rooms_csv')->only('index');
    }

    /**
     * Display the list of list hotel-rooms.
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

    /**
     * Exports a report of hotel rooms to a PDF file.
     * @param HotelRoomService $hotelRoomService Service to generate report data.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse PDF file download response.
     */
    public function print()
    {
        // Load a view file named 'print-hotel-rooms' which is located under the 'backend.clients.hotel-rooms' directory.
        $pdf = PDF::loadView('backend.clients.hotel-rooms.print-hotel-rooms', [
            'hotelRooms' => $this->hotelRoomService->getHotelRoomsWithService(null, ['*'])['data']
        ]);

        // Set the paper size for the PDF to 'A4' and the orientation to 'landscape' to achieve a wider format.
        $pdf->setPaper('A4', 'landscape');

        // Stream the PDF to the browser for download with a filename that includes today's date.
        return $pdf->stream('hotel-rooms-' . date('Y-m-d') . '.pdf');
    }
}
