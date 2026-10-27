<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = Client::orderBy('sort_order')->get();

        return view('pages.clients', [
            'clients' => $clients,
        ]);
    }
}
