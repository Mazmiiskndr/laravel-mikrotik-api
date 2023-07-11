<?php

namespace App\Http\Livewire\Backend\Client\HotelRooms;

use App\Services\Client\HotelRoom\HotelRoomService;
use App\Services\ServiceMegalos\ServiceMegalosService;
use App\Traits\CloseModalTrait;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class Edit extends Component
{
    // Traits LivewireMessageEvents and CloseModalTrait
    use LivewireMessageEvents;
    use CloseModalTrait;

    // Properties Public For Edit Hotel Room
    public $hotelRoomId, $idService, $roomNumber, $password;

    // For Services Selected In Edit Hotel Room
    public $services;

    // Listeners
    protected $listeners = [
        'getHotelRoomById' => 'showHotelRoom',
    ];

    /**
     * Mount the component.
     * @param ServiceMegalosService $serviceMegalosService
     */
    public function mount(ServiceMegalosService $serviceMegalosService)
    {
        // Get services from the database
        $this->services = $serviceMegalosService->getServices();
    }

    /**
     * Define validation rules for hotel Room creation.
     * @param string|null $id Hotel Room ID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     */
    public function getRules($id = null)
    {
        // If id is not provided, we're creating a new hotel Room, else we're updating an existing hotel Room.
        $passwordRule = 'required|min:5|max:32';
        if ($id !== null) {
            $passwordRule .= ",$id,id";
        }

        return [
            // REQUIRED
            'idService'        => 'required',
            'roomNumber'        => 'required',
            'password'         => $passwordRule,
        ];
    }

    /**
     * Define validation messages for hotel Room creation.
     * @return array Array of validation messages
     */
    public function getMessages()
    {
        return [
            'idService.required'       => 'Service ID cannot be empty!',
            'password.required'        => 'Password cannot be empty!',
            'roomNumber.required'      => 'Room Number cannot be empty!',
            'password.min'             => 'Password must be at least 5 characters!',
            'password.max'             => 'Password cannot be more than 32 characters!',
        ];
    }

    /**
     * Handle property updates.
     * @param string $property
     * @return void
     */
    public function updated($property)
    {
        $this->validateOnly($property, $this->getRules($this->hotelRoomId), $this->getMessages());
    }

    /**
     * Render the component `hotel rooms edit form modal`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.hotel-rooms.edit');
    }

    /**
     * Load hotel room data into the component.
     * This function is called when the 'showHotelRoom' event is mounted.
     * @param  \App\Services\HotelRoomService  $hotelRoomService The service to use to fetch the hotel room.
     * @param  int  $hotelRoomId The ID of the hotel roool to load.
     * @return void
     */
    public function showHotelRoom(HotelRoomService $hotelRoomService,$hotelRoomId)
    {
        // Fetch the hotel room using the provided service
        $hotelRoom = $hotelRoomService->getHotelRoomIdWithService($hotelRoomId);
        // If a hotel room was found, load the hotel room's data into the component's properties
        if ($hotelRoom) {
            $this->populateHotelRoomData($hotelRoom);
        }
        $this->dispatchBrowserEvent('show-modal');
    }

    /**
     * Update a hotel room's details using a HotelRoomService instance.
     * @param  HotelRoomService  $hotelRoomService
     * @return void
     * @throws \Exception if client update fails
     */
    public function updateHotelRoom(HotelRoomService $hotelRoomService)
    {
        // Validate the form data before submit
        $this->validate($this->getRules($this->hotelRoomId), $this->getMessages());

        // List of properties to include in the hotel room data
        $hotelRoomData = $this->prepareHotelRoomData();

        try {
            // Attempt to update the client
            $client = $hotelRoomService->updateHotelRoom($this->hotelRoomId, $hotelRoomData);

            // Check if the client was updated successfully
            if ($client === null) {
                throw new \Exception('Failed to update the client');
            }
            // Notify the frontend of success
            $this->dispatchSuccessEvent('Client was successfully updated.');
            // Let other components know that an client was updated
            $this->emit('hotelRoomUpdated', true);
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while updating client: ' . $th->getMessage());
        } finally {
            // Ensure the modal is closed
            $this->closeModal();
        }
    }

    /**
     * Populate the component's properties with the hotel room's data.
     * @param  object  $hotelRoom
     */
    protected function populateHotelRoomData($hotelRoom)
    {
        $this->hotelRoomId = $hotelRoom->id;
        $this->idService = $hotelRoom->service_id;
        $this->roomNumber = $hotelRoom->room_number;
        $this->password = $hotelRoom->password;
    }

    /**
     * Reset all fields to their default state.
     * @return void
     */
    public function resetFields()
    {
        $this->hotelRoomId = null;
        $this->idService = null;
        $this->roomNumber = null;
        $this->password = null;
        // $this->services = null;
    }

    /**
     * Prepares the hotel room data for the update operation.
     * @return array
     */
    protected function prepareHotelRoomData()
    {
        // List of properties to include in the update hotel room
        $hotelRoomProperties = [
            'idService', 'roomNumber', 'password',
        ];

        // Return Collect property values into an associative array
        return array_reduce($hotelRoomProperties, function ($carry, $property) {
            $carry[$property] = $this->$property;
            return $carry;
        }, []);
    }


}
