<?php

namespace App\Services\Client;

use LaravelEasyRepository\BaseService;

interface ClientService extends BaseService{

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

    /**
     * Create or update related RadCheck, RadAcct, and RadUserGroup entries.
     * @param string $username The username for related entries.
     * @param array $attributes The password for related entries.
     * @param string|null $idService The id service for related entries.
     * @param int|null $id The id of the client or voucher.
     * @param string|null $userType The type of user, 'client' or 'voucher'.
     * @throws \Exception if an error occurs while creating or updating related entries.
     */
    public function createOrUpdateRelatedEntries($username, $attributes, $idService, $id, $userType);

    /**
     * This method creates or updates entries in the radCheck table.
     * @param string $username The username of the client or voucher.
     * @param array $attributes The attributes for the radCheck entry.
     */
    public function createOrUpdateRadCheck($username, $attributes);

    /**
     * This method creates or updates entries in the radacct table.
     * @param string $username The username of the client or voucher.
     */
    public function createOrUpdateRadAcct($username);

    /**
     * This method creates or updates entries in the radUserGroup table.
     * @param object $attributes The username of the client or voucher.
     * @param int $voucherId The id of the client or voucher.
     * @param string $userType The type of user, 'client' or 'voucher'.
     */
    public function createOrUpdateRadUserGroup($attributes, $voucherId, $userType);

    /**
     * Deletes the related data from the radacct, radcheck, and radusergroup models.
     * @param string $username The username of the voucher.
     * @return void
     */
    public function deleteRelatedData($username);
}
