<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class SpaController
 * @package App\Http\Controllers
 */
class SpaController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return view('index');
    }
}
