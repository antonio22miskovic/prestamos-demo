<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display client profile (read-only for now)
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $client = $user->client;

        if (!$client) {
            $client = Client::create([
                'user_id' => $user->id,
                'employment' => null,
                'income' => 0,
                'expenses' => 0,
                'employment_years' => null,
                'company_name' => null,
            ]);
        }

        // Get uploaded documents
        $documents = $client->documents()->get()->keyBy('document_type');

        return view('client.profile.index', compact('client', 'documents'));
    }

    /**
     * Show edit profile form (future functionality)
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $client = $user->client;

        return view('client.profile.edit', compact('client'));
    }

    /**
     * Update profile (future functionality)
     */
    public function update(Request $request)
    {
        // TODO: Implement profile update functionality
        return redirect()->route('client.profile.index')
            ->with('info', 'Funcionalidad de edición de perfil en desarrollo');
    }
}