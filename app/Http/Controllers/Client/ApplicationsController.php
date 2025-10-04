<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ApplicationsController extends Controller
{
    /**
     * Display loan applications for the client
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

        // Get active application (optimized with select)
        $activeApplication = $client->loanApplications()
            ->select(['id', 'client_id', 'amount', 'term_months', 'purpose', 'status', 'created_at'])
            ->whereIn('status', ['draft', 'pending'])
            ->latest()
            ->first();

        // Get loan application history (optimized with select and eager loading)
        $loanHistory = $client->loanApplications()
            ->select(['id', 'client_id', 'amount', 'term_months', 'status', 'created_at'])
            ->with(['loan:id,loan_application_id,status'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.applications.index', compact('client', 'activeApplication', 'loanHistory'));
    }

    /**
     * Show specific application details
     */
    public function show(Request $request, $applicationId): View
    {
        $user = $request->user();
        $client = $user->client;

        $application = $client->loanApplications()
            ->with(['loan'])
            ->findOrFail($applicationId);

        // Get client documents
        $documents = $client->documents()->get()->keyBy('document_type');

        return view('client.applications.show', compact('client', 'application', 'documents'));
    }

    /**
     * Download a client document securely
     */
    public function downloadDocument(Request $request, $documentId): BinaryFileResponse
    {
        $user = $request->user();
        $client = $user->client;

        // Find the document and ensure it belongs to the authenticated client
        $document = ClientDocument::where('id', $documentId)
            ->where('client_id', $client->id)
            ->firstOrFail();

        // Check if file exists
        $filePath = storage_path('app/private/' . $document->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'Archivo no encontrado');
        }

        // Return the file with proper headers
        return response()->download($filePath, $document->original_name, [
            'Content-Type' => $document->mime_type,
        ]);
    }
}