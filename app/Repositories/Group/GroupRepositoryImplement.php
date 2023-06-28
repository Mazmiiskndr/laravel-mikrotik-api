<?php

namespace App\Repositories\Group;

use App\Helpers\ActionButtonsBuilder;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Group;
use App\Models\Module;
use App\Models\Page;
use App\Traits\DataTablesTrait;
use Illuminate\Support\Facades\Log;

class GroupRepositoryImplement extends Eloquent implements GroupRepository
{
    use DataTablesTrait;
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Group $model)
    {
        $this->model = $model;
    }

    /**
     * Generates a DataTables table with Group data from Redis, respecting user's permissions.
     * @return JSON DataTables instance, with "action" column buttons (raw). Sorted by latest.
     */
    public function getDatatables()
    {
        // Retrieve records from the database using the model, sort by the latest records
        $data = $this->model->latest()->get();

        $editRoute = 'backend.setup.admin.edit-group';
        $editPermission = 'edit_group';
        $onclickEdit = 'showGroup';
        $editButton = 'link';

        // Format the data for DataTables
        return $this->formatDataTablesResponse(
            $data,
            [
                'action' => function ($data) use ($editRoute,$editPermission, $editButton, $onclickEdit) {
                    return $this->getActionButtons($data, $editRoute, $editPermission, $editButton, $onclickEdit);
                }
            ]
        );
    }

    /**
     * Retrieves active page permissions, ordered by module ID and page ID.
     *
     * @return Collection of pages with associated module titles and IDs.
     */
    public function getDataPermissions()
    {
        $data = Page::with('module')
            ->whereHas('module', function ($query) {
                $query->where('root', '!=', 1);
                $query->where('active', 1);
            })
            ->select('id', 'title', 'allowed_groups')
            ->addSelect([
                'mod_title' => Module::select('title')
                    ->whereColumn('id', 'pages.module_id')
            ])
            ->orderBy('module_id', 'asc')
            ->orderBy('id', 'asc')
            ->get();
        return $data;
    }

    /**
     * Retrieves data from 'groups' and 'pages' tables based on group ID.
     * @param groupId The group's ID.
     * @return array Contains 'groupData' (data for the group) and 'pageIds' (IDs of allowed pages for the group).
     */
    public function getGroupAndPagesById($groupId)
    {
        // Initialize return array
        $groupAndPagesData = [];

        // Query 'groups' table where 'id' is $groupId
        $groupData = $this->model->find($groupId);

        // If groupData returns a result
        if ($groupData) {
            // Save group data to groupAndPagesData array
            $groupAndPagesData['groupData'] = $groupData;

            // Query 'pages' table, select 'id' and 'allowed_groups' columns
            $pageDataQuery = Page::select('id', 'allowed_groups as ag')->get();

            // If pageDataQuery returns results
            if ($pageDataQuery->count() > 0) {
                $pageIdsArray = [];

                // Loop through pageDataQuery results
                foreach ($pageDataQuery as $pageData) {
                    // Convert 'ag' column to array
                    $allowedGroupsArray = explode(',', $pageData->ag);

                    // If $groupId is in $allowedGroupsArray
                    if (in_array($groupId, $allowedGroupsArray)) {
                        // Add page 'id' to $pageIdsArray
                        $pageIdsArray[] = $pageData->id;
                    }
                }

                // Save pageIdsArray to groupAndPagesData array
                $groupAndPagesData['pageIds'] = $pageIdsArray;
            } else {
                $groupAndPagesData['pageIds'] = false;
            }
        } else {
            $groupAndPagesData['groupData'] = false;
        }

        // Return groupAndPagesData array
        return $groupAndPagesData;
    }

    /**
     * Creates a new group and updates page permissions.
     * @param string $groupName Group name.
     * @param array $permissions Page permissions, keyed by page ID.
     *
     * @return mixed Returns Group instance on success, Exception on failure.
     * @throws Exception if unable to create Group or update permissions.
     */
    public function storeNewGroup($groupName, $permissions)
    {
        try {
            // Create Group
            $group = $this->model->create([
                'name' => trim($groupName),
            ]);

            // Get all pages
            $pages = Page::all();

            // Loop through the pages
            foreach ($pages as $page) {
                $allowedGroups = explode(',', $page->allowed_groups);
                // If the permission for this page is set to "1" or if the page id is "1"
                if ($permissions[$page->id] == '1' || $page->id == '1') {
                    // If the group id is not in the allowed groups
                    if (!in_array($group->id, $allowedGroups)) {
                        // Add the group id to the allowed groups
                        $allowedGroups[] = $group->id;
                        // Update the page
                        $page->allowed_groups = implode(',', $allowedGroups);
                        $page->save();
                    }
                }
            }

            // Return the created group
            return $group;
        } catch (\Exception $e) {
            // Log the exception message for debugging and return false
            Log::error("Error in creating group : " . $e->getMessage());

            // Return the exception
            return $e;
        }
    }

    /**
     * Updates an existing group and its page permissions.
     * @param string $groupName New group name.
     * @param array $permissions Page permissions, keyed by page ID.
     * @param int $id ID of the group to be updated.
     *
     * @return mixed Returns Group instance on success, Exception on failure.
     * @throws Exception if unable to update Group or permissions.
     */
    public function updateGroup($groupName, $permissions, $id)
    {
        try {
            // Find Group by id
            $group = $this->model->findOrFail($id);

            // Update Group name
            $group->name = trim($groupName);
            $group->save();

            // Get all pages
            $pages = Page::all();

            // Loop through the pages
            foreach ($pages as $page) {
                $allowedGroups = explode(',', $page->allowed_groups);
                // If the permission for this page is set to "1" or if the page id is "1"
                if (isset($permissions[$page->id]) && $permissions[$page->id] == '1' || $page->id == '1') {
                    // If the group id is not in the allowed groups
                    if (!in_array($group->id, $allowedGroups)) {
                        // Add the group id to the allowed groups
                        $allowedGroups[] = $group->id;
                    }
                } else {
                    // If the group id is in the allowed groups and the permission is not "1", remove it
                    if (($key = array_search($group->id, $allowedGroups)) !== false) {
                        unset($allowedGroups[$key]);
                    }
                }

                // Update the page
                $page->allowed_groups = implode(',', $allowedGroups);
                $page->save();
            }

            // Return the updated group
            return $group;
        } catch (\Exception $e) {
            // Log the exception message for debugging and return false
            Log::error("Error in updating group : " . $e->getMessage());

            // Return the exception
            return $e;
        }
    }

    // 👇 **** PRIVATE FUNCTIONS **** 👇

    /**
     * Generate action buttons for the DataTables row.
     * @param $data
     * @param $editRoute
     * @param $editPermission
     * @param $editButton
     * @param $onclickEdit
     * @return string HTML string for the action buttons
     */
    private function getActionButtons($data, $editRoute, $editPermission, $editButton, $onclickEdit)
    {
        return (new ActionButtonsBuilder())
            ->setEditRoute($editRoute)
            ->setEditPermission($editPermission)
            ->setOnclickEdit($onclickEdit)
            ->setType($editButton)
            ->setIdentity($data->id)
            ->build();
    }
}
