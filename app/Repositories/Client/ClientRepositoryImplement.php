<?php

namespace App\Repositories\Client;

use App\Helpers\AccessControlHelper;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Client;
use App\Models\RadAcct;
use App\Models\RadCheck;
use App\Models\RadUserGroup;
use App\Models\Services;
use Exception;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ClientRepositoryImplement extends Eloquent implements ClientRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    protected $radCheckModel;
    protected $radAcctModel;
    protected $radUserGroupModel;

    public function __construct(Client $model, RadCheck $radCheckModel, RadAcct $radAcctModel, RadUserGroup $radUserGroupModel)
    {
        $this->model = $model;
        $this->radCheckModel = $radCheckModel;
        $this->radAcctModel = $radAcctModel;
        $this->radUserGroupModel = $radUserGroupModel;
    }

    /**
     * Retrieve client records and associated service names.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @return array
     */
    public function getClientWithService($conditions = null)
    {
        try {
            // Prepare the query to select clients and join with services
            $clientQuery = $this->model->select('clients.*', 'services.service_name')
                ->leftJoin('services', 'clients.service_id', '=', 'services.id');

            // Add the 'where' conditions if they exist
            if ($conditions) {
                $clientQuery = $clientQuery->where($conditions);
            }

            // Get the results and the count of rows
            $clientData['data'] = $clientQuery->get()->toArray();
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
        // Retrieve records from the database using the model, including the related 'clients' records, and sort by the latest records
        $data = $this->model->select('clients.client_uid', 'clients.username', 'services.service_name')
            ->leftJoin('services', 'clients.service_id', '=', 'services.id')
            ->latest()
            ->get();

        // Initialize DataTables and add columns to the table
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $editButton = '';
                $deleteButton = '';

                // Check if the current client is allowed to edit
                if (AccessControlHelper::isAllowedToPerformAction('edit_client')) {
                    // If client is allowed, show edit button
                    $editButton = '<button type="button" name="edit" class="edit btn btn-primary btn-sm" onclick="showClient(\'' . $data->client_uid . '\')"> <i class="fas fa-edit"></i></button>';
                }

                // Check if the current client is allowed to delete
                if (AccessControlHelper::isAllowedToPerformAction('delete_client')) {
                    // If client is allowed, show delete button
                    $deleteButton = '&nbsp;&nbsp;<button type="button" class="delete btn btn-danger btn-sm" onclick="confirmDeleteClient(\'' . $data->client_uid . '\')"> <i class="fas fa-trash"></i></button>';
                }

                return $editButton . $deleteButton;
            })
            ->rawColumns(['action'])
            ->make(true);
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
            'password'         => 'required|min:5|max:32',
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
        try {
            // Create new client, radcheck, radacct, and radusergroup entries
            $client = $this->createClient($request);
            $this->createRadCheck($client, $request);
            $this->createRadAcct($client);
            $this->createRadUserGroup($client);
            return $client;
        } catch (\Exception $e) {
            // If an exception occurred during the create process, log the error message.
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
        try {
            // Get the client from the database.
            $client = $this->getClientByUid($clientUid);
            // If the client exists, update its data.
            if ($client !== null) {
                // Update client data
                $client = $this->updateClientData($client, $data);

                // Update related radcheck, radacct, and radusergroup entries
                $this->updateRadCheck($client, $data);
                $this->updateRadAcct($client);
                $this->updateRadUserGroup($client);

                return $client;
            } else {
                throw new \Exception("Client with UID $clientUid not found.");
            }
        } catch (\Exception $e) {
            // If an exception occurred during the update process, log the error message.
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
                $this->radCheckModel->where('username', $username)->delete();
                $this->radAcctModel->where('username', $username)->delete();
                $this->radUserGroupModel->where('username', $username)->delete();
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


    // 👇 **** PRIVATE FUNCTIONS **** 👇

    /**
     * Creates a new client using the provided data.
     * @param array $data The data used to create the new client.
     * @param string $fileName The name of the client's banner image file.
     * @param string $thumbFileName The name of the client's thumbnail file.
     * @return Model|mixed The newly created client.
     */
    private function createClient($data)
    {
        if ($data['firstName'] && $data['lastName']) {
            $fullName = $data['firstName'] . ' ' . $data['lastName'];
        }
        return $this->model->create([
            'service_id'        => $data['idService'],
            'username'          => $data['username'],
            'password'          => $data['password'],
            'simultaneous_use'  => $data['simultaneousUse'] ?? 0,
            'validfrom'         => strtotime($data['validFrom']),
            'valid_until'       => strtotime($data['validTo']),
            'identification'    => $data['identificationNo'],
            'email'             => $data['emailAddress'],
            'first_name'        => $data['firstName'],
            'last_name'         => $data['lastName'],
            'fullname'          => $fullName ?? null,
            'birth_place'       => $data['placeOfBirth'],
            'birth_date'        => $data['dateOfBirth'],
            'phone'             => $data['phone'],
            'address'           => $data['address'],
            'note'              => $data['notes'],
        ]);
    }

    /**
     * Creates new entries in the radcheck table for the newly created client.
     * The entries can include: Cleartext-Password, Simultaneous-Use, Expiration, and ValidFrom.
     * @param Client $client The client object, containing client's data including username and password.
     * @param array $data The original data used to create the new client. It may contain 'simultaneousUse', 'validFrom', and 'validTo'.
     * @return void
     */
    private function createRadCheck(Client $client, $data)
    {
        // For each attribute, we will first check if an entry exists, and if it does, update it, otherwise create a new entry.
        $attributes = [
            'Cleartext-Password' => $client->password,
            'Simultaneous-Use' => $data['simultaneousUse'] ?? null,
            'Expiration' => !empty($data['validTo']) ? date('F d Y H:i:s', strtotime($data['validTo'])) : null,
            'ValidFrom' => $data['validFrom'] ?? null,
        ];

        foreach ($attributes as $attribute => $value) {
            if ($value !== null) {
                $entry = $this->radCheckModel->where([
                    'username' => $client->username,
                    'attribute' => $attribute,
                ])->first();

                $data = [
                    'username' => $client->username,
                    'attribute' => $attribute,
                    'op' => $attribute == 'ValidFrom' ? '>=' : ':=',
                    'value' => $value,
                ];

                if ($entry) {
                    $entry->update($data);
                } else {
                    $this->radCheckModel->create($data);
                }
            }
        }
    }

    /**
     * Creates a new record in the 'radacct' table for a given client.
     * @param Client $client The client for which to create a new 'radacct' record.
     * @return void
     */
    private function createRadAcct(Client $client)
    {
        // Create an entry for the client
        $this->radAcctModel->create([
            'acctsessionid' => '',
            'acctuniqueid' => '',
            'username' => $client->username,
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
        ]);
    }

    /**
     * Creates a new record in the 'radusergroup' table for a given client.
     * @param Client $client The client for which to create a new 'radusergroup' record.
     * @return void
     */
    private function createRadUserGroup(Client $client)
    {
        // Fetch the service_name for this client
        $service = Services::find($client->id_service);

        // Create an entry in the 'radusergroup' table
        $this->radUserGroupModel->create([
            'username' => $client->username,
            'groupname' => $service->service_name ?? '',
            'priority' => 1,
            'user_type' => 'client',
            'voucher_id' => $client->id, // or another appropriate field
        ]);
    }

    /**
     * Updates an existing client's data.
     * @param Model|mixed $client The client to update.
     * @param array $data The data used to update the client.
     * @return Model|mixed The updated client.
     */
    private function updateClientData($client, $data)
    {
        if ($data['firstName'] && $data['lastName']) {
            $fullName = $data['firstName'] . ' ' . $data['lastName'];
        }
        // Update the client's data and save the client.
        $client->service_id = $data['idService'];
        $client->username = $data['username'];
        $client->password = $data['password'];
        $client->simultaneous_use = $data['simultaneousUse'] ?? 0;
        $client->validfrom = strtotime($data['validFrom']);
        $client->valid_until = strtotime($data['validTo']);
        $client->identification = $data['identificationNo'];
        $client->email = $data['emailAddress'];
        $client->first_name = $data['firstName'];
        $client->last_name = $data['lastName'];
        $client->fullname = $fullName ?? null;
        $client->birth_place = $data['placeOfBirth'];
        $client->birth_date = $data['dateOfBirth'];
        $client->phone = $data['phone'];
        $client->address = $data['address'];
        $client->note = $data['notes'];
        $client->save();

        return $client;
    }

    /**
     * Updates the existing entries in the radcheck table for the specified client.
     * @param Client $client The client object, containing client's data including username and password.
     * @param array $data The original data used to update the client. It may contain 'simultaneousUse', 'validFrom', and 'validTo'.
     * @return void
     */
    private function updateRadCheck(Client $client, $data)
    {
        $attributes = [
            'Cleartext-Password' => $client->password,
            'Simultaneous-Use' => $data['simultaneousUse'] ?? null,
            'Expiration' => !empty($data['validTo']) ? date('F d Y H:i:s', strtotime($data['validTo'])) : null,
            'ValidFrom' => $data['validFrom'] ?? null,
        ];

        foreach ($attributes as $attribute => $value) {
            if ($value !== null) {
                $entry = $this->radCheckModel->where([
                    'username' => $client->username,
                    'attribute' => $attribute,
                ])->first();

                $updateData = [
                    'username' => $client->username,
                    'attribute' => $attribute,
                    'op' => $attribute == 'ValidFrom' ? '>=' : ':=',
                    'value' => $value,
                ];

                if ($entry) {
                    $entry->update($updateData);
                } else {
                    $this->radCheckModel->create($updateData);
                }
            }
        }
    }

    /**
     * Updates an existing record in the 'radacct' table for a given client.
     * @param Client $client The client for which to update a 'radacct' record.
     * @return void
     */
    private function updateRadAcct(Client $client)
    {
        // Fetch the existing record
        $record = $this->radAcctModel->where('username', $client->username)->first();

        // If the record exists, update it.
        if ($record) {
            $record->username = $client->username;  // You can replace with other fields you want to update
            // Add other fields to update here
            $record->save();
        }
    }

    /**
     * Updates an existing record in the 'radusergroup' table for a given client.
     * @param Client $client The client for which to update a 'radusergroup' record.
     * @return void
     */
    private function updateRadUserGroup(Client $client)
    {
        // Fetch the service_name for this client
        $service = Services::find($client->service_id);

        // Fetch the existing record
        $record = $this->radUserGroupModel->where('username', $client->username)->first();

        // If the record exists, update it.
        if ($record) {
            $record->groupname = $service->service_name ?? '';
            $record->user_type = 'client';  // You can replace with other fields you want to update
            // Add other fields to update here
            $record->save();
        }
    }


}
