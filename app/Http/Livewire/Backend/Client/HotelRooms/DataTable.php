<?php

namespace App\Http\Livewire\Backend\Client\HotelRooms;

use App\Services\Client\HotelRoom\HotelRoomService;
use Livewire\Component;

class DataTable extends Component
{

    // Listeners
    protected $listeners = [
        'hotelRoomUpdated' => 'refreshDataTable',
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
}
