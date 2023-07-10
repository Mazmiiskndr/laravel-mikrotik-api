<?php

namespace App\Http\Livewire\Backend\Client\HotelRooms;

use App\Exports\HotelRoomExport;
use App\Services\Client\HotelRoom\HotelRoomService;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class DataTable extends Component
{

    // Listeners
    protected $listeners = [
        'hotelRoomUpdated' => 'refreshDataTable',
        'saveToExcel' => 'saveToExcel',
    ];

    /**
     * Render the component `data-table-hotel-rooms`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.hotel-rooms.data-table');
    }

    /**
     * Get data `list-hotel-rooms` for the DataTable.
     * @param HotelRoomService $hotelRoomService Voucher service instance
     * @return mixed
     */
    public function getDataTable(HotelRoomService $hotelRoomService)
    {
        return $hotelRoomService->getDatatableHotelRooms();
    }

    /**
     * Refresh the DataTable when an hotel rooms is created, updated and deleted.
     */
    public function refreshDataTable()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }

    /**
     * Exports a report of online users to a XlSX file.
     * @param HotelRoomService $hotelRoomService Service to generate report data.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse XlSX file download response.
     */
    public function saveToExcel(HotelRoomService $hotelRoomService)
    {
        return Excel::download(new HotelRoomExport($hotelRoomService), 'hotel-rooms-' . date('Y-m-d') . '.xlsx');
    }
}
