<?php

namespace App\Http\Livewire\Backend\Profile;

use App\Services\Admin\AdminService;
use Livewire\Component;

class MyProfile extends Component
{
    // Properties Public Variables
    public $user_uid, $fullname, $role;

    // Listeners
    protected $listeners = [
        'myProfileUpdated' => 'handleUpdated',
    ];

    /**
     * Mount the component.
     * @param AdminService $adminService The instance of AdminService.
     */
    public function mount(AdminService $adminService)
    {
        $user = $adminService->getAdminByUid($this->user_uid);
        $this->showDetailProfile($user);
    }

    /**
     * Render the component.
     * @return \Illuminate\View\View The view of the user's profile page.
     */
    public function render()
    {
        return view('livewire.backend.profile.my-profile');
    }

    /**
     * Handle the 'myProfileUpdated' event.
     */
    public function handleUpdated(AdminService $adminService)
    {
        $this->mount($adminService);
    }

    /**
     * Show the detail profile of the user.
     * @param User $user The user model instance.
     */
    public function showDetailProfile($user)
    {
        $this->fullname = $user->fullname;
        $this->role = $user->group->name;
    }
}
