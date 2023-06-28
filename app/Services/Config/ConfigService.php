<?php

namespace App\Services\Config;

use LaravelEasyRepository\BaseService;

interface ConfigService extends BaseService{

    /**
     * Returns a DataTables response with all module information for non-null 'flag_module' fields.
     * @return \Yajra\DataTables\DataTables JSON response for the DataTables.
     */
    public function getDatatables();

    /**
     * Retrieves the 'url_redirect' setting from the current model's table.
     * @return Model The Eloquent model instance for the 'url_redirect' setting.
     */
    public function getUrlRedirect();

    /**
     * Updates or creates 'url_redirect' setting based on the given request data.
     * @param  mixed $request The request data to update or create settings with.
     */
    public function updateUrlRedirect($request);
}
