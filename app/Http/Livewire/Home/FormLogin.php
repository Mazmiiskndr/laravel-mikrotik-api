<?php

namespace App\Http\Livewire\Home;

use App\Services\Admin\AdminService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormLogin extends Component
{

    // Declare public variables for username and password
    public $username, $password;

    // Define an array of validation rules for the variables
    protected $rules = [
        'username' => 'required', // The username is required
        'password' => 'required', // The password is required
    ];

    // Define an array of custom error messages for validation failures
    protected $messages = [
        'username.required' => 'Username is required!', // Error message if the username is not provided
        'password.required' => 'Password is required!', // Error message if the password is not provided
    ];

    /**
     * updated
     *
     * @param  mixed $property
     * @return void
     */
    public function updated($property)
    {
        // Every time a property changes
        // (only `text` for now), validate it
        $this->validateOnly($property);
    }

    /**
     * render
     */
    public function render()
    {
        return view('livewire.home.form-login');
    }

    /**
     * Handle the form submission.
     * @param AdminService $adminService - The AdminService to use for admin authentication
     * @return mixed - Returns a redirect response on success, or flashes an error message on failure
     */
    public function submit(AdminService $adminService)
    {
        try {
            // Validate the form input fields
            $this->validate();

            // Attempt to validate the provided admin credentials using the AdminService
            $validationResult = $adminService->validateAdmin($this->username, $this->password);

            // Check if the validation was successful
            if ($validationResult['success']) {
                // If the validation was successful, retrieve the session data from the validation result
                $sessionData = $validationResult['session_data'];

                // Set the session data for the authenticated user
                session([
                    'user_uid'      => $sessionData['user_uid'],
                    'fullname'      => $sessionData['fullname'],
                    'login_status'  => $sessionData['login_status'],
                    'role'          => $sessionData['role'],
                    'username'      => $sessionData['username'],
                ]);

                // Redirect the user to the backend dashboard
                return redirect()->route('backend.dashboard');
            }

            // If the validation fails, flash an error message
            return session()->flash('error', $validationResult['message']);
        } catch (\Exception $e) {
            // If there's an exception, log it for debugging
            // Log::error('An error occurred during admin authentication: ' . $e->getMessage());

            // Flash a general error message
            return session()->flash('error', 'An error occurred : ' . $e->getMessage());
        }
    }

}
