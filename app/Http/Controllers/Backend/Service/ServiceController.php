<?php

namespace App\Http\Controllers\Backend\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * ServiceController constructor.
     * Apply appropriate permissions for each method in the controller.
     */
    public function __construct()
    {
        // Apply permissions middleware to each method as required.
        $this->middleware('checkPermissions:list_services,add_new_service')->only('index');
        $this->middleware('checkPermissions:premium_services')->only('showPremiumServices');
        $this->middleware('checkPermissions:add_new_service')->only('create');
        $this->middleware('checkPermissions:edit_service')->only('edit');
        $this->middleware('checkPermissions:edit_premium_service')->only('editPremiumServices');
    }

    /**
     * Prepare the view with necessary data.
     * @param string $viewName Name of the view.
     * @param Request $request Current request instance.
     * @param int|null $serviceId Service ID (optional).
     * @return \Illuminate\View\View The prepared view.
     */
    private function loadView($viewName, Request $request, $serviceId = null)
    {
        // Get permissions from request attributes set by the middleware.
        $permissions = $request->attributes->get('permissions');
        $data = compact('permissions');

        // If serviceId is provided, add it to the data array.
        if (!is_null($serviceId)) {
            $data['serviceId'] = $serviceId;
        }

        // Return the view with the prepared data.
        return view('backend.services.' . $viewName, $data);
    }

    /**
     * Handle a request to show the list of services.
     * @param Request $request Current request instance.
     * @return \Illuminate\View\View The services list view.
     */
    public function index(Request $request)
    {
        return $this->loadView('list-services', $request);
    }

    /**
     * Handle a request to show the "add new service" form.
     *
     * @param Request $request Current request instance.
     * @return \Illuminate\View\View The "add new service" view.
     */
    public function create(Request $request)
    {
        return $this->loadView('add-new-service', $request);
    }

    /**
     * Handle a request to show the "edit service" form.
     * @param int $serviceId The ID of the service to be edited.
     * @param Request $request Current request instance.
     * @return \Illuminate\View\View The "edit service" view.
     */
    public function edit($serviceId, Request $request)
    {
        return $this->loadView('edit-service', $request, $serviceId);
    }

    /**
     * Handle a request to show the list of premium services.
     * @param Request $request Current request instance.
     * @return \Illuminate\View\View The premium services list view.
     */
    public function showPremiumServices(Request $request)
    {
        return $this->loadView('premium-services', $request);
    }

    /**
     * Handle a request to show the "edit premium service" form.
     * @param int $serviceId The ID of the premium service to be edited.
     * @param Request $request Current request instance.
     * @return \Illuminate\View\View The "edit premium service" view.
     */
    public function editPremiumServices($serviceId, Request $request)
    {
        return $this->loadView('edit-premium-service', $request, $serviceId);
    }
}
