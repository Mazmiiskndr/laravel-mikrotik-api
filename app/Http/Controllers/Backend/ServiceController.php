<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display the `list-services`.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.services.list-services');
    }

}
