<?php

namespace App\Http\Livewire\Backend\Setup\Config\Form;

use App\Services\Config\UserData\UserDataService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class UsersData extends Component
{
    use LivewireMessageEvents;
    // Declare Public Variables
    public $id_column, $name_column, $email_column, $phone_number_column, $room_number_column, $date_column, $first_name_column,
        $last_name_column, $mac_column, $location_column, $gender_column, $birthday_column, $login_with_column, $display_id,
        $display_name, $display_email, $display_phone_number, $display_room_number, $display_date, $display_first_name,
        $display_last_name, $display_mac, $display_location, $display_gender, $display_birthday, $display_login_with;

    // Livewire properties
    protected $listeners = [
        'userDataUpdated' => '$refresh',
        'resetForm' => 'resetForm',
    ];

    /**
     * Defines validation rules for input data.
     * @return array The merged validation rules for columns and displays
     */
    protected function rules()
    {
        // Define the rules for column values
        $columnRules = 'required|numeric|min:0|max:1';
        // Define the rules for display values
        $displayRules = 'required|string|regex:/^[a-zA-Z0-9\s\-_]+$/';

        // Apply column rules to relevant attributes
        $columns = [
            'id_column' => $columnRules,
            'name_column' => $columnRules,
            'email_column' => $columnRules,
            'phone_number_column' => $columnRules,
            'room_number_column' => $columnRules,
            'date_column' => $columnRules,
            'first_name_column' => $columnRules,
            'last_name_column' => $columnRules,
            'mac_column' => $columnRules,
            'location_column' => $columnRules,
            'gender_column' => $columnRules,
            'birthday_column' => $columnRules,
            'login_with_column' => $columnRules,
        ];

        // Apply display rules to relevant attributes
        $displays = [
            'display_id' => $displayRules,
            'display_name' => $displayRules,
            'display_email' => $displayRules,
            'display_phone_number' => $displayRules,
            'display_room_number' => $displayRules,
            'display_date' => $displayRules,
            'display_first_name' => $displayRules,
            'display_last_name' => $displayRules,
            'display_mac' => $displayRules,
            'display_location' => $displayRules,
            'display_gender' => $displayRules,
            'display_birthday' => $displayRules,
            'display_login_with' => $displayRules,
        ];
        // Merge column and display rules into a single array and return
        return array_merge(
            $columns,
            $displays
        );
    }

    /**
     * Specifies default error messages for validation rules.
     * @return array The default error messages for various validation rules
     */
    protected function messages()
    {
        // Define the default error messages for various validation rules
        $dafaultMessages = [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute field must be a number.',
            'min' => 'The :attribute field must be at least :min.',
            'max' => 'The :attribute field may not be greater than :max.',
            'regex' => 'The :attribute field may only contain letters, numbers, spaces, dashes, and underscores.',
            'string' => 'The :attribute field must be string.',
        ];

        return $dafaultMessages;
    }

    /**
     * Retrieves the UserData parameters using the UserDataService and resets the form.
     * @param  UserDataService $userDataService
     */
    public function mount(UserDataService $userDataService)
    {
        $this->resetForm($userDataService);
    }

    /**
     * Validates the updated property.
     * @param  string $property The property that was updated
     */
    public function updated($property)
    {
        // Every time a property changes
        // (only `text` for now), validate it
        $this->validateOnly($property);
    }

    /**
     * Renders the form for editing user data.
     * @return \Illuminate\View\View The form view
     */
    public function render()
    {
        return view('livewire.backend.setup.config.form.users-data');
    }

    /**
     * Updates user data settings.
     * @param UserDataService $userDataService
     */
    public function updateUserData(UserDataService $userDataService)
    {
        // Validate the form
        $this->validate();
        // Get the settings from the form and store them in a variable
        $settings = $this->getVariables();
        try {
            // Update the user Data settings
            $userDataService->updateUserDataSettings($settings);
            // Show Message Success
            $this->dispatchSuccessEvent('User Data settings updated successfully.');
            // Emit the 'userDataUpdated' event with a true status
            $this->emitUp('userDataUpdated', true);
        } catch (\Throwable $th) {
            // Show Message Error
            $this->dispatchErrorEvent('An error occurred while updating user Data settings: ' . $th->getMessage());
        } finally {
            // Close the modal
            $this->closeModal();
        }
    }

    /**
     * Retrieves the UserData parameters using the UserDataService and stores them
     * in the corresponding Livewire properties. Renders the edit-router view.
     * @param  mixed $userDataService
     * @return void
     */
    public function resetForm(UserDataService $userDataService)
    {
        // Get the USERDATA parameters using the UserDataService
        $userDataParameters = $userDataService->getUserDataParameters();
        // Convert the received data into an associative array and fill it into a Livewire variable
        $this->setLivewireVariables($userDataParameters);
    }

    /**
     * Emits a closeModal event.
     */
    public function closeModal()
    {
        // Reset the form for the next client
        $this->resetFields();
        $this->emit('closeModal');
    }

    /**
     * Sets Livewire variables based on user data parameters.
     * @param  array $userDataParameters
     */
    private function setLivewireVariables($userDataParameters)
    {
        // Set each property if it exists in the Livewire component
        foreach ($userDataParameters as $userData) {
            if (property_exists($this, $userData->setting)) {
                $this->{$userData->setting} = $userData->value;
            }
        }
    }

    /**
     * Returns an array of public variable names.
     *
     * @return array The array containing the names of all public variables
     */
    public function getVariableNames()
    {
        return [
            'id_column', 'name_column', 'email_column', 'phone_number_column', 'room_number_column', 'date_column', 'first_name_column',
            'last_name_column', 'mac_column', 'location_column', 'gender_column', 'birthday_column', 'login_with_column', 'display_id',
            'display_name', 'display_email', 'display_phone_number', 'display_room_number', 'display_date', 'display_first_name',
            'display_last_name', 'display_mac', 'display_location', 'display_gender', 'display_birthday', 'display_login_with'
        ];
    }

    /**
     * The function resets the values of public variables to an empty string.
     */
    public function resetFields()
    {
        // Retrieve the public variable names
        $variables = $this->getVariableNames();

        // Reset the public variable values
        foreach ($variables as $variable) {
            $this->$variable = '';
        }
    }

    /**
     * Retrieves all public variable names and their current values.
     * @return array The array containing the names and values of all public variables
     */
    public function getVariables()
    {
        // Retrieve the public variable names
        $variables = $this->getVariableNames();

        // Declare the settings
        $settings = [];

        // Fill the settings array with public variable values
        foreach ($variables as $variable) {
            $settings[$variable] = $this->$variable;
        }

        return $settings;
    }

}
