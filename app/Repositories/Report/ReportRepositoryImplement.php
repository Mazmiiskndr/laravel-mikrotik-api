<?php

namespace App\Repositories\Report;

use App\Helpers\AccessControlHelper;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\RadAcct;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportRepositoryImplement extends Eloquent implements ReportRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $radAcctModel;

    public function __construct(RadAcct $radAcctModel)
    {
        $this->radAcctModel = $radAcctModel;
    }

    /**
     * Retrieves get all list radacct records where 'acctstoptime' is NULL.
     * Also, includes the first usage time for each user.
     * @return array An array that contains rows of data and number of rows.
     */
    public function getAllRadAcct()
    {
        // Prepare the data.
        $result = [];

        // Fetch the data where 'acctstoptime' is NULL and 'starttime' is not NULL.
        $result['rows'] = $this->radAcctModel->select([
            'username',
            'acctstarttime as starttime',
            'nasipaddress',
            'framedipaddress as ipaddress',
            'acctsessiontime',
            'callingstationid as macaddress'
        ])
            ->whereNull('acctstoptime')
            ->whereNotNull('acctstarttime')
            ->get()
            ->map(function ($item) {
                $item->oltime = strtotime($item->starttime);
                return $item;
            });

        // Count the number of rows where 'acctstoptime' is NULL and 'starttime' is not NULL.
        $result['num_rows'] = $this->radAcctModel->whereNull('acctstoptime')->whereNotNull('acctstarttime')->count();

        // Add the 'firsttime' to each row.
        foreach ($result['rows'] as $row) {
            $row->firsttime = $this->getFirstUse($row->username);
        }

        // Return the result.
        return $result;
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables()
    {
        // Retrieve records from the database using getAllRadAcct function
        $data = $this->getAllRadAcct()['rows'];

        // Initialize DataTables and add columns to the table
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('firstuse', function ($data) {
                return $data->firsttime;
            })
            ->addColumn('sessionstart', function ($data) {
                return $data->starttime;
            })
            ->addColumn('onlinetime', function ($data) {
                return gmdate('j\d H:i:s', $data->oltime);
            })
            ->addColumn('ipaddress', function ($data) {
                return $data->ipaddress;
            })
            ->addColumn('macaddress', function ($data) {
                return $data->macaddress;
            })
            ->rawColumns(['firstuse', 'sessionstart', 'onlinetime', 'ipaddress', 'macaddress'])
            ->make(true);
    }

    /**
     * Fetches the first 'acctstarttime' for a given username where 'acctstarttime' is not NULL.
     * @param string $username The username for which the first usage time is to be fetched.
     * @return string|bool The first usage time if it exists, otherwise false.
     */
    private function getFirstUse($username)
    {
        // Fetch the first 'acctstarttime' for the given username where 'acctstarttime' is not NULL.
        $query = $this->radAcctModel->select('acctstarttime as firsttime')
            ->where('username', $username)
            ->whereNotNull('acctstarttime')
            ->orderBy('acctstarttime')
            ->first();

        // Check if 'firsttime' exists and return it. Otherwise, return false.
        if (!empty($query->firsttime)) {
            return $query->firsttime;
        } else {
            return false;
        }
    }
}
