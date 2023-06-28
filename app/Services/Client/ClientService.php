<?php

namespace App\Services\Client;

use LaravelEasyRepository\BaseService;

interface ClientService extends BaseService{

    /**
     * Retrieve client records and associated service names.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @return array
     */
    public function getClientWithService($conditions);

    /**
     * Retrieve client by uid.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $clientUid
     * @return array
     */
    public function getClientByUid($clientUid);

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables();

    /**
     * Define validation rules for client creation.
     * @param string|null $clientUid Client UID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     */
    public function getRules($clientUid);

    /**
     * Define validation messages for client creation.
     * @return array Array of validation messages
     */
    public function getMessages();

    /**
     * Stores a new client using the provided request data.
     * @param array $request The data used to create the new client.
     * @return Model|mixed The newly created client.
     * @throws \Exception if an error occurs while creating the client.
     */
    public function storeNewClient($request);

    /**
     * Updates an existing client using the provided data.
     * @param string $clientUid The UID of the client to update.
     * @param array $data The data used to update the client.
     * @return Model|mixed The updated client.
     * @throws \Exception if an error occurs while updating the client.
     */
    public function updateClient($clientUid, $data);

    /**
     * Delete client data from the `clients`, `radcheck`, `radacct`, and `radusergroup` tables based on the client UID.
     * @param string $clientUid The UID of the client to delete.
     */
    public function deleteClientData($clientUid);
}
