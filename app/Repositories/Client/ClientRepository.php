<?php

namespace App\Repositories\Client;

use LaravelEasyRepository\Repository;

interface ClientRepository extends Repository{

    /**
     * Retrieve client records and associated service names.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @param array|null $columns
     * @return array
     */
    public function getClientWithService($conditions, $columns);

    /**
     * Retrieve client by uid.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $clientId
     * @return array
     */
    public function getClientById($clientId);

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables();

    /**
     * Define validation rules for client creation.
     * @param string|null $clientId Client UID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     */
    public function getRules($clientId = null);

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
     * @param string $clientId The UID of the client to update.
     * @param array $data The data used to update the client.
     * @return Model|mixed The updated client.
     * @throws \Exception if an error occurs while updating the client.
     */
    public function updateClient($clientId, $data);

    /**
     * Delete client data from the `clients`, `radcheck`, `radacct`, and `radusergroup` tables based on the client UID.
     * @param string $clientId The UID of the client to delete.
     */
    public function deleteClientData($clientId);
}
