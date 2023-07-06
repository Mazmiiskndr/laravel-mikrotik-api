<?php

namespace App\Http\Livewire\Backend\Setup\Administrator\Admin;

use App\Models\Group;
use App\Services\Admin\AdminService;
use App\Traits\CloseModalTrait;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class Edit extends Component
{
    // Traits LivewireMessageEvents and CloseModalTrait
    use LivewireMessageEvents;
    use CloseModalTrait;

    // Properties Public Variables
    public $adminId, $group_id, $username, $password, $fullname, $email, $status;

    // Groups
    public $groups;

    // Listeners
    protected $listeners = [
        'getAdmin' => 'showAdmin',
        'adminUpdated' => '$refresh',
    ];

    /**
     * Validation rules.
     * @return array
     */
    protected function getRules()
    {
        $rules = [
            'group_id'      => 'required',
            'username'      => 'required|min:4|max:60|regex:/^\S*$/u|unique:admins,username,' . $this->adminId . ',id',
            'status'        => 'required',
            'fullname'      => 'required|min:4|max:100',
            'email'         => 'required|email|unique:admins,email,' . $this->adminId . ',id',
        ];
        // If password is not empty
        if (!empty($this->password)) {
            $rules['password'] = 'min:6';
        }
        return $rules;
    }

    /**
     * Validation messages.
     * @return array
     */
    protected function getMessages()
    {
        $messages = [
            'group_id.required'         => 'Choose Group cannot be empty!',
            'username.required'         => 'Username cannot be empty!',
            'username.min'              => 'Username must be at least 4 characters!',
            'username.max'              => 'Username cannot be more than 60 characters!',
            'username.unique'           => 'Username already exists!',
            'username.regex'            => 'Username cannot contain any spaces!',
            'status.required'           => 'Status cannot be empty!',
            'fullname.required'         => 'Full Name cannot be empty!',
            'fullname.min'              => 'Full Name must be at least 4 characters!',
            'fullname.max'              => 'Full Name cannot be more than 100 characters!',
            'email.required'            => 'Email Address cannot be empty!',
            'email.email'               => 'Email Address must be a valid email address!',
            'email.unique'              => 'Email Address already exists!',
        ];
        // If password is not empty
        if (!empty($this->password)) {
            $messages['password.min'] = 'Password must be at least 6 characters!';
        }
        return $messages;
    }

    /**
     * Prepare component state.
     * @return void
     */
    public function mount()
    {
        $this->groups = Group::orderBy('created_at', 'ASC')->get();
    }

    /**
     * Property update handler.
     * @param  string $property
     * @return void
     */
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    /**
     * Render the component.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.setup.administrator.admin.edit');
    }

    /**
     * Load admin details into the component.
     * @param  AdminService $adminService
     * @param  string $adminId
     * @return void
     */
    public function showAdmin(AdminService $adminService, $adminId)
    {
        $admin = $adminService->getAdminByUid($adminId);

        $this->dispatchBrowserEvent('show-modal');

        $this->adminId = $admin['id'];
        $this->group_id = $admin['group_id'];
        $this->username = $admin['username'];
        $this->fullname = $admin['fullname'];
        $this->email = $admin['email'];
        $this->status = $admin['status'];
    }

    /**
     * Update admin details.
     * @param  AdminService $adminService
     * @return void
     */
    public function updateAdmin(AdminService $adminService)
    {
        // Validate the data first
        $this->validate($this->getRules(), $this->getMessages());
        // Declare the public variable names
        $variables = ['adminId', 'group_id', 'username', 'fullname', 'email', 'status'];

        // Collect property values into an associative array
        $newAdmin = array_reduce($variables, function ($carry, $property) {
            $carry[$property] = $this->$property;
            return $carry;
        }, []);

        try {
            // Update the admin dataAdmin
            $adminService->updateAdmin($this->adminId, $newAdmin);

            // Show Message Success
            $this->dispatchSuccessEvent('Admin successfully updated.');
            // Emit the 'adminUpdated' event with a true status
            $this->emit('adminUpdated', true);
        } catch (\Throwable $th) {
            // Show Message Error
            $this->dispatchErrorEvent('An error occurred while updating admin: ' . $th->getMessage());
        } finally {
            // Ensure the modal is closed
            $this->closeModal();
        }
    }

    /**
     * The function resets all fields to their default values.
     */
    public function resetFields()
    {
        $this->adminId = '';
        $this->group_id = '';
        $this->username = '';
        $this->fullname = '';
        $this->email = '';
        $this->status = '';
    }
}
