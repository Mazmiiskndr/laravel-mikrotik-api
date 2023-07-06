<?php

namespace App\Services\Client;

use LaravelEasyRepository\Service;
use App\Repositories\Client\ClientRepository;
use App\Traits\HandleRepositoryCall;
use Exception;

class ClientServiceImplement extends Service implements ClientService
{
    use HandleRepositoryCall;

    protected $mainRepository;
    /**
     * Constructor.
     * @param ClientRepository $mainRepository The main repository for settings.
     */
    public function __construct(ClientRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
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
        return $this->handleRepositoryCall('getClientWithService', [$conditions,$columns]);
    }

    /**
     * Retrieve client by uid.
     * @param array|null $clientId
     * @return array
     * @throws Exception if an error occurs during the repository method call.
     */
    public function getClientById($clientId)
    {
        return $this->handleRepositoryCall('getClientById', [$clientId]);
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return mixed The result of the getDatatables repository method call.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function getDatatables()
    {
        return $this->handleRepositoryCall('getDatatables');
    }

    /**
     * Define validation rules for client creation.
     * @param string|null $clientId Client UID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     * @throws Exception if an error occurs during the repository method call.
     */
    public function getRules($clientId = null)
    {
        return $this->handleRepositoryCall('getRules', [$clientId]);
    }

    /**
     * Define validation messages for client creation.
     * @return array Array of validation messages
     * @throws Exception if an error occurs during the repository method call.
     */
    public function getMessages()
    {
        return $this->handleRepositoryCall('getMessages');
    }

    /**
     * Stores a new client using the provided request data.
     * @param array $request The data used to create the new client.
     * @return mixed The newly created client.
     * @throws Exception if an error occurs while creating the client.
     */
    public function storeNewClient($request)
    {
        return $this->handleRepositoryCall('storeNewClient', [$request]);
    }

    /**
     * Updates an existing client using the provided data.
     * @param string $clientId The UID of the client to update.
     * @param array $data The data used to update the client.
     * @return mixed The updated client.
     * @throws Exception if an error occurs while updating the client.
     */
    public function updateClient($clientId, $data)
    {
        return $this->handleRepositoryCall('updateClient', [$clientId, $data]);
    }

    /**
     * Delete client data from the `clients`, `radcheck`, `radacct`, and `radusergroup` tables based on the client UID.
     * @param string $clientId The UID of the client to delete.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function deleteClientData($clientId)
    {
        return $this->handleRepositoryCall('deleteClientData', [$clientId]);
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
        return $this->handleRepositoryCall('createOrUpdateRelatedEntries', [$username, $attributes, $idService, $id, $userType]);
    }

    /**
     * This method creates or updates entries in the radCheck table.
     * @param string $username The username of the client or voucher.
     * @param array $attributes The attributes for the radCheck entry.
     */
    public function createOrUpdateRadCheck($username, $attributes)
    {
        return $this->handleRepositoryCall('createOrUpdateRadCheck', [$username, $attributes]);
    }

    /**
     * This method creates or updates entries in the radacct table.
     * @param string $username The username of the client or voucher.
     */
    public function createOrUpdateRadAcct($username)
    {
        return $this->handleRepositoryCall('createOrUpdateRadAcct', [$username]);
    }

    /**
     * This method creates or updates entries in the radUserGroup table.
     * @param object $attributes The username of the client or voucher.
     * @param int $voucherId The id of the client or voucher.
     * @param string $userType The type of user, 'client' or 'voucher'.
     */
    public function createOrUpdateRadUserGroup($attributes, $voucherId = null , $userType = 'client')
    {
        return $this->handleRepositoryCall('createOrUpdateRadUserGroup', [$attributes, $voucherId, $userType]);
    }

    /**
     * Deletes the related data from the radacct, radcheck, and radusergroup models.
     * @param string $username The username of the voucher.
     * @return void
     */
    public function deleteRelatedData($username)
    {
        return $this->handleRepositoryCall('deleteRelatedData', [$username]);
    }

}
