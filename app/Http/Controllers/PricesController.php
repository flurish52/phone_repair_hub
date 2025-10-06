<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PricesController extends Controller
{

    public function index()
    {
        return inertia::render('Prices', [

        ]);
    }
}
