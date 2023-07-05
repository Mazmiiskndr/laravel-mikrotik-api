<?php

namespace App\Repositories\Client;

use App\Helpers\AccessControlHelper;
use App\Helpers\ActionButtonsBuilder;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Client;
use App\Models\RadAcct;
use App\Models\RadCheck;
use App\Models\RadUserGroup;
use App\Models\Services;
use App\Traits\DataTablesTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ClientRepositoryImplement extends Eloquent implements ClientRepository
{
    use DataTablesTrait;
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    protected $radCheckModel;
    protected $radAcctModel;
    protected $radUserGroupModel;
    protected $serviceModel;

    public function __construct(Client $model, RadCheck $radCheckModel, RadAcct $radAcctModel, RadUserGroup $radUserGroupModel, Services $serviceModel)
    {
        $this->model = $model;
        $this->radCheckModel = $radCheckModel;
        $this->radAcctModel = $radAcctModel;
        $this->radUserGroupModel = $radUserGroupModel;
        $this->serviceModel = $serviceModel;
    }

    /**
     * Retrieve client records and associated service names.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @param array|null $columns
     * @return array
     */
    public function getClientWithService($conditions = null, $columns = ['*'])
    {
        try {
            // Prepare the query to select clients and include their associated service
            $clientQuery = $this->model->select($columns)->with(['service' => function ($query) {
                $query->select('id', 'service_name'); // Assuming 'id' is the primary key of 'services'
            }]);

            // Add the 'where' conditions if they exist
            if ($conditions) {
                $clientQuery = $clientQuery->where($conditions);
            }

            // Get the results and the count of rows
            $clientData['data'] = $clientQuery->latest()->get();
            $clientData['total'] = $clientQuery->count();

            return $clientData;
        } catch (Exception $e) {
            // Log the exception message and return an empty array
            Log::error("Error getting data clients : " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Retrieve client by uid.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $clientUid
     * @return array
     */
    public function getClientByUid($clientUid)
    {
        try {
            // Prepare the query to select clients and join with services
            $clientQuery = $this->model->where('client_uid', $clientUid)->first();

            return $clientQuery;
        } catch (Exception $e) {
            // Log the exception message and return an empty array
            Log::error("Error getting data client by uid : " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables()
    {
        // Retrieve records from the database using the model, including the related 'admin' records, and sort by the latest records
        $clientData = $this->getClientWithService(null, ['client_uid', 'service_id', 'username']);
        $data = $clientData['data'];

        $editPermission = 'edit_client';
        $deletePermission = 'delete_client';
        $onclickEdit = 'showClient';
        $onclickDelete = 'confirmDeleteClient';
        $editButton = 'button';

        // Format the data for DataTables
        return $this->formatDataTablesResponse(
            $data,
            [
                'service_name' => function ($data) {
                    return $data->service->service_name;
                },
                'action' => function ($data) use ($editPermission, $deletePermission, $editButton, $onclickEdit, $onclickDelete) {
                    return $this->getActionButtons($data, $editPermission, $deletePermission, $editButton, $onclickEdit, $onclickDelete);
                }
            ]
        );
    }

    /**
     * Define validation rules for client creation.
     * @param string|null $clientUid Client UID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     */
    public function getRules($clientUid = null)
    {
        // If clientUid is not provided, we're creating a new client, else we're updating an existing client.
        $usernameRule = 'required|min:5|max:32|regex:/^\S*$/u|unique:clients,username';
        $emailRule = 'nullable|email|max:80|unique:clients,email';
        if ($clientUid !== null) {
            $usernameRule .= ",$clientUid,client_uid";
            $emailRule .= ",$clientUid,client_uid";
        }

        return [
            // REQUIRED
            'idService'        => 'required',
            'username'         => $usernameRule,
            'password'          => ['required', 'min:5', 'max:32'],
            // NULLABLE
            'simultaneousUse'  => 'nullable|integer|min:1',
            'validFrom'        => 'nullable|date_format:Y-m-d H:i',
            'validTo'          => 'nullable|date_format:Y-m-d H:i',
            'identificationNo' => 'nullable|string|max:30',
            'emailAddress'     => $emailRule,
            'firstName'        => 'nullable|string|max:40',
            'lastName'         => 'nullable|string|max:40',
            'placeOfBirth'     => 'nullable|string|min:2|max:30',
            'dateOfBirth'      => 'nullable|date',
            'address'          => 'nullable|max:120',
            'phone'            => 'nullable|max:15',
            'notes'            => 'nullable|string|max:100',
        ];
    }

    /**
     * Define validation messages for client creation.
     * @return array Array of validation messages
     */
    public function getMessages()
    {
        return [
            'idService.required'       => 'Service ID cannot be empty!',
            'username.required'        => 'Username cannot be empty!',
            'username.min'             => 'Username must be at least 5 characters!',
            'username.max'             => 'Username cannot be more than 32 characters!',
            'username.unique'          => 'Username already exists!',
            'username.regex'           => 'Username cannot contain any spaces!',
            'password.required'        => 'Password cannot be empty!',
            'password.min'             => 'Password must be at least 5 characters!',
            'password.max'             => 'Password cannot be more than 32 characters!',
            'simultaneousUse.integer'  => 'Simultaneous Use must be a number!',
            'simultaneousUse.min'      => 'Simultaneous Use field must contain a number greater than zero.!',
            'validFrom.date_format'    => 'Valid From must be a valid datetime (YYYY-MM-DD HH:MM:SS)!',
            'validTo.date_format'      => 'Valid To must be a valid datetime (YYYY-MM-DD HH:MM:SS)!',
            'identificationNo.max'     => 'Identification Number cannot be more than 30 characters!',
            'emailAddress.email'       => 'Email Address must be a valid email address!',
            'emailAddress.unique'      => 'Email Address already exists!',
            'emailAddress.max'         => 'Email Address cannot be more than 80 characters!',
            'firstName.string'         => 'First Name must be a string!',
            'firstName.max'            => 'First Name cannot be more than 40 characters!',
            'lastName.string'          => 'Last Name must be a string!',
            'lastName.max'             => 'Last Name cannot be more than 40 characters!',
            'placeOfBirth.string'      => 'Place Of Birth must be a string!',
            'placeOfBirth.min'         => 'Place Of Birth must be at least 2 characters!',
            'placeOfBirth.max'         => 'Place Of Birth cannot be more than 30 characters!',
            'lastName.max'             => 'Last Name cannot be more than 40 characters!',
            'phone.max'                => 'Phone cannot be more than 15 characters!',
            'address.max'              => 'Address cannot be more than 120 characters!',
            'dateOfBirth.date'         => 'Date of Birth must be a valid date!',
            'notes.max'                => 'Notes cannot be more than 100 characters!',
        ];
    }

    /**
     * Stores a new client using the provided request data.
     * @param array $request The data used to create the new client.
     * @return Model|mixed The newly created client.
     * @throws \Exception if an error occurs while creating the client.
     */
    public function storeNewClient($request)
    {
        // Start a new database transaction.
        DB::beginTransaction();

        try {
            // Create new client, radcheck, radacct, and radusergroup entries
            $client = $this->createOrUpdateClient($request);

            // For each attribute, we will first check if an entry exists, and if it does, update it, otherwise create a new entry.
            $attributes = $this->prepareAttributesRadCheck($client->password, $request);
            // Create a new entry in radCheck, Radacctm RadUserGroup table for this create client.
            $this->createOrUpdateRelatedEntries($client->username, $attributes, $client->service_id);


            // Commit the transaction (apply the changes).
            DB::commit();

            return $client;
        } catch (\Exception $e) {
            // If an exception occurred during the create process, rollback the transaction.
            DB::rollBack();

            // Log the error message.
            Log::error("Failed to store new client : " . $e->getMessage());

            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
    }

    /**
     * Updates an existing client using the provided data.
     * @param string $clientUid The UID of the client to update.
     * @param array $data The data used to update the client.
     * @return Model|mixed The updated client.
     * @throws \Exception if an error occurs while updating the client.
     */
    public function updateClient($clientUid, $data)
    {
        // Start a new database transaction.
        DB::beginTransaction();

        try {
            // Get the client from the database.
            $client = $this->getClientByUid($clientUid);
            // If the client exists, update its data.
            if ($client !== null) {
                // Update client data
                $client = $this->createOrUpdateClient($data);

                // For each attribute, we will first check if an entry exists, and if it does, update it, otherwise create a new entry.
                $attributes = $this->prepareAttributesRadCheck($client->password, $data);
                // Create a new entry in radCheck, Radacctm RadUserGroup table for this update client.
                $this->createOrUpdateRelatedEntries($client->username, $attributes, $client->service_id);

                // Commit the transaction (apply the changes).
                DB::commit();

                return $client;
            } else {
                throw new \Exception("Client with UID $clientUid not found.");
            }
        } catch (\Exception $e) {
            // Rollback the Transaction.
            DB::rollBack();
            // Log the error message
            Log::error("Failed to update client : " . $e->getMessage());
            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
    }

    /**
     * Delete client data from the `clients`, `radcheck`, `radacct`, and `radusergroup` tables based on the client UID.
     * @param string $clientUid The UID of the client to delete.
     * @throws \Exception if an error occurs while deleting the client.
     */
    public function deleteClientData($clientUid)
    {
        try {
            // Retrieve the client from the database.
            $client = $this->model->where('client_uid', $clientUid)->first();

            // If the client exists, delete its associated data from all related tables.
            if ($client !== null) {
                // Delete data from the 'clients' table.
                $client->delete();

                // Delete data from the 'radcheck', 'radacct', and 'radusergroup' tables based on the client's username.
                $username = $client->username;
                // Delete related data from radcheck, radacct and radusergroup
                $this->deleteRelatedData($username);
            } else {
                throw new \Exception("Client with UID $clientUid not found.");
            }
        } catch (\Exception $e) {
            // If an exception occurred during the deletion process, log the error message.
            Log::error("Failed to delete client data : " . $e->getMessage());
            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
    }

    /**
     * Create or update related RadCheck, RadAcct, and RadUserGroup entries.
     * @param string $username The username for related entries.
     * @param array $attributes The password for related entries.
     * @param string|null $idService The id service for related entries.
     * @param int|null $id The id of the client or voucher.
     * @param string|null $userType The type of user, 'client' or 'voucher'.
     * @throws \Exception if an error occurs while creating or updating related entries.
     */
    public function createOrUpdateRelatedEntries($username, $attributes, $idService, $id = null, $userType = 'client')
    {
        // Start a new database transaction.
        DB::beginTransaction();

        try {
            $this->createOrUpdateRadCheck($username, $attributes);
            $this->createOrUpdateRadAcct($username);
            $this->createOrUpdateRadUserGroup($username, $idService, $id, $userType);

            // Commit the transaction (apply the changes).
            DB::commit();
        } catch (\Exception $e) {
            // If an exception occurred, rollback the transaction.
            DB::rollBack();

            // Log the error message.
            Log::error("Failed to create or update related entries : " . $e->getMessage());

            // Rethrow the exception.
            throw $e;
        }
    }

    /**
     * This method creates or updates entries in the radCheck table.
     * @param string $username The username of the client or voucher.
     * @param array $attributes The attributes for the radCheck entry.
     */
    public function createOrUpdateRadCheck($username, $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            if ($value !== null) {
                $data = [
                    'username' => $username,
                    'attribute' => $attribute,
                    'op' => $attribute == 'ValidFrom' ? '>=' : ':=',
                    'value' => $value,
                ];

                $this->radCheckModel->updateOrCreate(
                    [
                        'username' => $username,
                        'attribute' => $attribute,
                    ],
                    $data
                );
            }
        }
    }

    /**
     * This method creates or updates entries in the radUserGroup table.
     * @param string $username The username of the client or voucher.
     * @param string $idService The username of the client or voucher.
     * @param int $voucherId The id of the client or voucher.
     * @param string $userType The type of user, 'client' or 'voucher'.
     */
    public function createOrUpdateRadUserGroup($username, $idService, $voucherId = null, $userType = 'client')
    {
        // Fetch the service_name for this user
        $service = $this->serviceModel->find($idService);

        $data = [
            'username' => $username,
            'groupname' => $service->service_name ?? '',
            'priority' => 1,
            'user_type' => $userType,
            'voucher_id' => $voucherId,
        ];

        $this->radUserGroupModel->updateOrCreate(
            [
                'username' => $username,
            ],
            $data
        );
    }

    /**
     * This method creates or updates entries in the radacct table.
     * @param string $username The username of the client or voucher.
     */
    public function createOrUpdateRadAcct($username)
    {
        // Default data for 'radacct' entry
        $data = [
            'acctsessionid' => '',
            'acctuniqueid' => '',
            'username' => $username,
            'groupname' => '',
            'realm' => '',
            'nasipaddress' => '',
            'calledstationid' => '',
            'callingstationid' => '',
            'acctterminatecause' => '',
            'framedipaddress' => '',
            'framedipv6address' => '',
            'framedipv6prefix' => '',
            'framedinterfaceid' => '',
            'delegatedipv6prefix' => '',
        ];

        $this->radAcctModel->updateOrCreate(
            [
                'username' => $username,
            ],
            $data
        );
    }

    /**
     * Deletes the related data from the radacct, radcheck, and radusergroup models.
     * @param string $username The username of the voucher.
     * @return void
     */
    public function deleteRelatedData($username)
    {
        // Delete related data from radacct
        $this->radAcctModel->where('username', $username)->delete();

        // Delete related data from radcheck
        $this->radCheckModel->where('username', $username)->delete();

        // Delete related data from radusergroup
        $this->radUserGroupModel->where('username', $username)->delete();
    }

    // 👇 **** PRIVATE FUNCTIONS **** 👇

    /**
     * Prepare the attributes for the radcheck table.
     * @param string $password The password for the attribute 'Cleartext-Password'.
     * @param array $request The request data used to populate other attributes.
     * @return array The prepared attributes for the radcheck table.
     */
    private function prepareAttributesRadCheck($password, $request)
    {
        return [
            'Cleartext-Password' => $password,
            'Simultaneous-Use' => $request['simultaneousUse'] ?? null,
            'Expiration' => !empty($request['validTo']) ? date('F d Y H:i:s', strtotime($request['validTo'])) : null,
            'ValidFrom' => $request['validFrom'] ?? null,
        ];
    }

    /**
     * Generate action buttons for the DataTables row.
     * @param $data
     * @param $editPermission
     * @param $deletePermission
     * @param $editButton
     * @param $onclickEdit
     * @param $onclickDelete
     * @return string HTML string for the action buttons
     */
    private function getActionButtons($data, $editPermission, $deletePermission, $editButton, $onclickEdit, $onclickDelete)
    {
        return (new ActionButtonsBuilder())
            ->setEditPermission($editPermission)
            ->setDeletePermission($deletePermission)
            ->setOnclickDelete($onclickDelete)
            ->setOnclickEdit($onclickEdit)
            ->setType($editButton)
            ->setIdentity($data->client_uid)
            ->build();
    }

    /**
     * Creates or updates a client using the provided data.
     * @param array $data The data used to create or update the client.
     * @return Model|mixed The newly created or updated client.
     */
    private function createOrUpdateClient($data)
    {
        // If the client's first name and last name are provided, create a full name.
        if ($data['firstName'] && $data['lastName']) {
            $data['fullname'] = $data['firstName'] . ' ' . $data['lastName'];
        }

        // If the simultaneous use is not provided, set it to 0.
        $data['simultaneous_use'] = $data['simultaneousUse'] ?? 0;

        $data['service_id'] = $data['idService'];
        $data['username'] = strtolower($data['username']);
        $data['validfrom'] = strtotime($data['validFrom']);
        $data['valid_until'] = strtotime($data['validTo']);
        $data['identification'] = $data['identificationNo'];
        $data['email'] = $data['emailAddress'];
        $data['first_name'] = $data['firstName'];
        $data['last_name'] = $data['lastName'];
        $data['birth_place'] = $data['placeOfBirth'];
        $data['birth_date'] = $data['dateOfBirth'];
        $data['phone'] = $data['phone'];
        $data['address'] = $data['address'];
        $data['note'] = $data['notes'];

        // Update or create client, based on username
        return $this->model->updateOrCreate(
            ['username' => $data['username']],
            $data
        );
    }


}
