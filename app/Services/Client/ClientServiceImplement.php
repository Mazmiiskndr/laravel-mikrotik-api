<?php

namespace App\Services\Client;

use LaravelEasyRepository\Service;
use App\Repositories\Client\ClientRepository;
use Exception;

class ClientServiceImplement extends Service implements ClientService
{
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
     * Handles the method call to the repository and manages exceptions.
     * @param string $method The method to call.
     * @param array $parameters The parameters to pass to the method.
     * @throws Exception If there is an error when calling the method.
     * @return mixed The result of the method call.
     */
    private function handleRepositoryCall(string $method, array $parameters = [])
    {
        try {
            return $this->mainRepository->{$method}(...$parameters);
        } catch (Exception $exception) {
            $errorMessage = "Error when calling $method: " . $exception->getMessage();
            throw new Exception($errorMessage);
        }
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
     * @param array|null $clientUid
     * @return array
     * @throws Exception if an error occurs during the repository method call.
     */
    public function getClientByUid($clientUid)
    {
        return $this->handleRepositoryCall('getClientByUid', [$clientUid]);
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
     * @param string|null $clientUid Client UID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     * @throws Exception if an error occurs during the repository method call.
     */
    public function getRules($clientUid = null)
    {
        return $this->handleRepositoryCall('getRules', [$clientUid]);
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
     * @param string $clientUid The UID of the client to update.
     * @param array $data The data used to update the client.
     * @return mixed The updated client.
     * @throws Exception if an error occurs while updating the client.
     */
    public function updateClient($clientUid, $data)
    {
        return $this->handleRepositoryCall('updateClient', [$clientUid, $data]);
    }

    /**
     * Delete client data from the `clients`, `radcheck`, `radacct`, and `radusergroup` tables based on the client UID.
     * @param string $clientUid The UID of the client to delete.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function deleteClientData($clientUid)
    {
        return $this->handleRepositoryCall('deleteClientData', [$clientUid]);
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
