<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    protected $adminService;
    /**
     * Create a new controller instance.
     * @param AdminService $adminService The instance of AdminService.
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Display the login page.
     * @return \Illuminate\View\View The view of the login page.
     */
    public function index()
    {
        // Check if the user is already authenticated
        if (Cookie::get('session_key')) {
            // Redirect to the dashboard page
            return redirect()->route('backend.dashboard')->with('auth', 'You are already logged in!');
        }

        // Set page layout
        $pageConfigs = ['myLayout' => 'blank'];
        // Return view
        return view('home.login.index', ['pageConfigs' => $pageConfigs]);
    }

    /**
     * Logout the user.
     * @return \Illuminate\Http\RedirectResponse The response after logout.
     */
    public function logout()
    {
        // Call the logout method from the repository and get the forgotten cookie
        $forgottenCookie = $this->adminService->logout();

        // Redirect to the login page or home page with the forgotten cookie
        return redirect('')->withCookie($forgottenCookie);
    }

}
