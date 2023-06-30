<?php

namespace App\Http\Livewire\Backend\Setup\Administrator\Admin;

use App\Models\Group;
use App\Services\Admin\AdminService;
use App\Traits\CloseModalTrait;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class Create extends Component
{
    // Traits LivewireMessageEvents and CloseModalTrait
    use LivewireMessageEvents;
    use CloseModalTrait;
    // Properties Public Variables
    public $groupId, $username, $password, $status, $fullName, $emailAddress, $password_confirmation;

    // Groups
    public $groups;

    // Listeners
    protected $listeners = [
        'adminCreated' => '$refresh',
    ];

    // Validation Rules
    protected $rules = [
        'groupId'       => 'required',
        'username'      => 'required|min:4|max:60|unique:admins,username,username|regex:/^\S*$/u',
        'password'      => 'required|min:6|confirmed',
        'status'        => 'required',
        'fullName'      => 'required|min:4|max:100',
        'emailAddress'  => 'required|email|unique:admins,email',
    ];

    // Validation Messages
    protected $messages = [
        'groupId.required'          => 'Choose Group cannot be empty!',
        'username.required'         => 'Username cannot be empty!',
        'username.min'              => 'Username must be at least 4 characters!',
        'username.max'              => 'Username cannot be more than 60 characters!',
        'username.unique'           => 'Username already exists!',
        'username.regex'            => 'Username cannot contain any spaces!',
        'password.required'         => 'Password cannot be empty!',
        'password.min'              => 'Password must be at least 6 characters!',
        'password.confirmed'        => 'Password and Confirm Password must match!',
        'status.required'           => 'Status cannot be empty!',
        'fullName.required'         => 'Full Name cannot be empty!',
        'fullName.min'              => 'Full Name must be at least 4 characters!',
        'fullName.max'              => 'Full Name cannot be more than 100 characters!',
        'emailAddress.required'     => 'Email Address cannot be empty!',
        'emailAddress.email'        => 'Email Address must be a valid email address!',
        'emailAddress.unique'       => 'Email Address already exists!',
    ];

    /**
     * Initialize component state.
     */
    public function mount()
    {
        // Reset form fields to their default state
        $this->resetFields();

        // Fetch all groups ordered by creation date
        $this->groups = Group::orderBy('created_at', 'ASC')->get();
    }

    /**
     * Event handler for property updates.
     * @param string $property Property that was updated
     */
    public function updated($property)
    {
        // Validate the updated property
        $this->validateOnly($property);
    }

    /**
     * Render the component.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.setup.administrator.admin.create');
    }

    /**
     * Store a new admin.
     * @param AdminService $adminService Admin service instance
     */
    public function storeNewAdmin(AdminService $adminService)
    {
        // Validate form fields
        $this->validate();

        // List of properties to include in the new admin
        $properties = ['groupId', 'username', 'password', 'status', 'fullName', 'emailAddress'];

        // Collect property values into an associative array
        $newAdmin = array_reduce($properties, function ($carry, $property) {
            $carry[$property] = $this->$property;
            return $carry;
        }, []);

        try {
            // Attempt to create the new admin
            $admin = $adminService->storeNewAdmin($newAdmin);

            // Check if the admin was created successfully
            if ($admin === null) {
                throw new \Exception('Failed to create the admin');
            }

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Admin was created successfully.');

            // Reset the form for the next admin
            $this->resetFields();

            // Let other components know that an admin was created
            $this->emit('adminCreated', true);
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while creating admin: ' . $th->getMessage());
        } finally {
            // Ensure the modal is closed
            $this->closeModal();
        }
    }

    /**
     * Reset form fields to their default state.
     */
    public function resetFields()
    {
        $this->groupId = '';
        $this->username = '';
        $this->password = '';
        $this->status = '';
        $this->fullName = '';
        $this->emailAddress = '';
        $this->password_confirmation = '';
    }
}
