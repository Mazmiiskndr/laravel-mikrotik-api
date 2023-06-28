<?php

namespace App\Http\Livewire\Backend\Setup\Config\Form;

use App\Services\Config\HotelRoom\HotelRoomService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class HotelRooms extends Component
{
    use LivewireMessageEvents;

    // Declare public variables
    public $hmsConnect = null;

    // Livewire properties
    protected $listeners = [
        'hmsConnectUpdated' => '$refresh',
        'resetForm' => 'resetForm',
    ];

    // Validation rules
    protected $rules = [
        // Required fields
        'hmsConnect' => 'required|numeric|min:0|max:1',
    ];

    // Validation messages
    protected $messages = [
        'hmsConnect.required' => 'HMS Connect cannot be empty!',
        'hmsConnect.numeric' => 'HMS Connect must be numeric!',
        'hmsConnect.min' => 'HMS Connect must have a minimum length of 0!',
        'hmsConnect.max' => 'HMS Connect must have a maximum length of 1!',
    ];


    /**
     * Retrieves the HOTEL ROOM parameters using the HotelRoomService and stores them
     * in the corresponding Livewire properties. Renders the edit-router view.
     * @param  HotelRoomService $hotelRoomService
     * @return \Illuminate\View\View
     */
    public function mount(HotelRoomService $hotelRoomService)
    {
        $this->resetForm($hotelRoomService);
    }

    /**
     * Renders the hotel-rooms view.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.setup.config.form.hotel-rooms');
    }

    /**
     * Updates the hotel room settings.
     * @param  HotelRoomService $hotelRoomService
     * @return void
     */
    public function updateHotelRoom(HotelRoomService $hotelRoomService)
    {
        $this->validate();
        // Create the settings array
        $settings = [
            'hms_connect' => $this->hmsConnect,
        ];

        try {
            // Update the HOTEL ROOM settings
            $hotelRoomService->updateHotelRoomSettings($settings);
            // Show Message Success
            $this->dispatchSuccessEvent('Hotel Room settings updated successfully.');
            // Emit the 'hotelRoomUpdated' event with a true status
            $this->emitUp('hotelRoomUpdated', true);
        } catch (\Throwable $th) {
            // Show Message Error
            $this->dispatchErrorEvent('An error occurred while updating hotel room settings: ' . $th->getMessage());
        } finally {
            // Close the modal
            $this->closeModal();
        }
    }

    /**
     * Closes the modal window.
     * @return void
     */
    public function closeModal()
    {
        // Reset the form for the next client
        $this->resetFields();
        $this->emit('closeModal');
    }

    /**
     * Retrieves the HOTEL ROOM parameters using the HotelRoomService and stores them
     * in the corresponding Livewire properties. Renders the edit-router view.
     * @param  mixed $hotelRoomService
     * @return void
     */
    public function resetForm(HotelRoomService $hotelRoomService)
    {
        // Get the HOTELROOM parameters using the HotelRoomService
        $hotelRoom = $hotelRoomService->getHotelRoomParameters();
        $this->hmsConnect = $hotelRoom->value;
    }

    /**
     * Resets the form fields.
     * @return void
     */
    public function resetFields()
    {
        $this->hmsConnect = null;
    }
}
