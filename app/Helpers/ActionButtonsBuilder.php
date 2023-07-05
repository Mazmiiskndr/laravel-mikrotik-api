<?php

namespace App\Helpers;

use App\Models\Services;
use LaravelEasyRepository\Service;

class ActionButtonsBuilder
{
    private $editRoute;
    private $editPermission;
    private $deletePermission;
    private $type = 'button';
    private $onclickEdit;
    private $onclickDelete;
    private $identity;

    /**
     * Set the unique identifier for the current data row.
     * @param mixed $identity
     * @return $this
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * Set the route name for the edit action.
     * @param string $editRoute
     * @return $this
     */
    public function setEditRoute($editRoute)
    {
        $this->editRoute = $editRoute;
        return $this;
    }

    /**
     * Set the permission required for the edit action.
     * @param string $editPermission
     * @return $this
     */
    public function setEditPermission($editPermission)
    {
        $this->editPermission = $editPermission;
        return $this;
    }

    /**
     * Set the permission required for the delete action.
     * @param string $deletePermission
     * @return $this
     */
    public function setDeletePermission($deletePermission)
    {
        $this->deletePermission = $deletePermission;
        return $this;
    }

    /**
     * Set the type of the action button (e.g. link or button).
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Set the JavaScript function to be called when the edit button is clicked.
     * @param string $onclickEdit
     * @return $this
     */
    public function setOnclickEdit($onclickEdit)
    {
        $this->onclickEdit = $onclickEdit;
        return $this;
    }

    /**
     * Set the JavaScript function to be called when the delete button is clicked.
     * @param string $onclickDelete
     * @return $this
     */
    public function setOnclickDelete($onclickDelete)
    {
        $this->onclickDelete = $onclickDelete;
        return $this;
    }

    /**
     * Build the HTML string for the edit button according to the given permissions and identity.
     * @return string
     */
    private function buildEditButton()
    {
        $editButton = '';

        // Check if the current user is allowed to perform the edit action
        if ($this->editPermission && AccessControlHelper::isAllowedToPerformAction($this->editPermission)) {
            if ($this->type == 'link') {
                // Generate the edit button as a link
                $editButton = '<a href="' . route($this->editRoute, $this->identity) . '" class="edit btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
            } else {
                // Generate the edit button as a button with the onclick event handler
                $editButton = '&nbsp;&nbsp;<button type="button" class="edit btn btn-primary btn-sm" onclick="' . $this->onclickEdit . '(\'' . $this->identity . '\')"> <i class="fas fa-edit"></i></button>';
            }
        }

        return $editButton;
    }

    /**
     * Build the HTML string for the delete button according to the given permissions and identity.
     * @return string
     */
    private function buildDeleteButton()
    {
        $deleteButton = '';
        // Get the default service
        $service = Services::where('service_name', 'DefaultService')->first();

        // Check if the delete permission is given, the current user is allowed to perform the delete action, and the service is not the default service (ID != 1)
        if ($this->deletePermission && AccessControlHelper::isAllowedToPerformAction($this->deletePermission)) {
            // Check if it's not the case of delete_service permission with identity 1
            if (!($this->deletePermission == "delete_service" && $this->identity == $service->id)) {
                // Generate the delete button with the onclick event handler
                $deleteButton = '&nbsp;&nbsp;<button type="button" class="delete btn btn-danger btn-sm" onclick="' . $this->onclickDelete . '(\'' . $this->identity . '\')"> <i class="fas fa-trash"></i></button>';
            }
        }

        return $deleteButton;
    }

    /**
     * Build the HTML string for the edit and delete buttons according to the given permissions and identity.
     * @return string
     */
    public function build()
    {
        // Generate the action buttons HTML
        return $this->buildEditButton() . $this->buildDeleteButton();
    }

}
