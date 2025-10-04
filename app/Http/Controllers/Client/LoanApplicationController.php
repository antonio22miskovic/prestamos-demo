<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\LoanApplication;
use App\Models\ClientDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LoanApplicationController extends Controller
{
    /**
     * Show the loan application steps
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $client = $user->client;
        
        // Create client profile if it doesn't exist
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

        // Check if there's an active application
        $activeApplication = $client->loanApplications()
            ->whereIn('status', ['draft', 'pending'])
            ->latest()
            ->first();

        return view('client.loan-application.index', compact('client', 'activeApplication'));
    }

    /**
     * Show step 1: Personal Information
     */
    public function step1(Request $request): View
    {
        $user = $request->user();
        $client = $user->client;
        
        // Create client profile if it doesn't exist
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

        return view('client.loan-application.step1', compact('client'));
    }

    /**
     * Process step 1: Personal Information
     */
    public function processStep1(Request $request)
    {
        $request->validate([
            'employment' => 'required|string|in:Empleado privado,Empleado público,Independiente,Empresario,Pensionado',
            'income' => 'required|numeric|min:1|max:999999.99',
            'expenses' => 'required|numeric|min:0|max:999999.99',
            'employment_years' => 'required|integer|min:0|max:50',
            'company_name' => 'required|string|min:2|max:255',
        ], [
            'employment.required' => 'La situación laboral es requerida.',
            'employment.in' => 'Selecciona una situación laboral válida.',
            'income.required' => 'Los ingresos mensuales son requeridos.',
            'income.min' => 'Los ingresos deben ser mayor a $0.',
            'income.max' => 'Los ingresos no pueden exceder $999,999.99.',
            'expenses.required' => 'Los gastos mensuales son requeridos.',
            'expenses.min' => 'Los gastos no pueden ser negativos.',
            'expenses.max' => 'Los gastos no pueden exceder $999,999.99.',
            'employment_years.required' => 'Los años de experiencia son requeridos.',
            'employment_years.min' => 'Los años de experiencia no pueden ser negativos.',
            'employment_years.max' => 'Los años de experiencia no pueden exceder 50.',
            'company_name.required' => 'El nombre de la empresa es requerido.',
            'company_name.min' => 'El nombre de la empresa debe tener al menos 2 caracteres.',
            'company_name.max' => 'El nombre de la empresa no puede exceder 255 caracteres.',
        ]);

        // Additional validation: income must be greater than expenses
        if ($request->income <= $request->expenses) {
            return back()->withErrors([
                'income' => 'Los ingresos deben ser mayores a los gastos para poder solicitar un préstamo.'
            ])->withInput();
        }

        $user = $request->user();
        $client = $user->client;

        $client->update([
            'employment' => $request->employment,
            'income' => $request->income,
            'expenses' => $request->expenses,
            'employment_years' => $request->employment_years,
            'company_name' => $request->company_name,
        ]);

        return redirect()->route('client.loan-application.step2')
            ->with('success', 'Información personal guardada correctamente.');
    }

    /**
     * Show step 2: Loan Details
     */
    public function step2(Request $request): View
    {
        $user = $request->user();
        $client = $user->client;

        // Get or create draft application
        $application = $client->loanApplications()
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (!$application) {
            $application = LoanApplication::create([
                'client_id' => $client->id,
                'amount' => 0,
                'term_months' => 12,
                'purpose' => null,
                'status' => 'draft',
                'loan_data' => null,
            ]);
        }

        return view('client.loan-application.step2', compact('client', 'application'));
    }

    /**
     * Process step 2: Loan Details
     */
    public function processStep2(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:100000',
            'term_months' => 'required|integer|in:6,12,18,24,36,48',
            'purpose' => 'required|string|min:10|max:500',
        ], [
            'amount.required' => 'El monto del préstamo es requerido.',
            'amount.min' => 'El monto mínimo es $1,000.',
            'amount.max' => 'El monto máximo es $100,000.',
            'term_months.required' => 'El plazo de pago es requerido.',
            'term_months.in' => 'Selecciona un plazo válido (6, 12, 18, 24, 36 o 48 meses).',
            'purpose.required' => 'El propósito del préstamo es requerido.',
            'purpose.min' => 'El propósito debe tener al menos 10 caracteres.',
            'purpose.max' => 'El propósito no puede exceder 500 caracteres.',
        ]);

        $user = $request->user();
        $client = $user->client;

        // Validate client has completed step 1
        if (!$client || !$client->employment || !$client->income || !$client->company_name) {
            return redirect()->route('client.loan-application.step1')
                ->with('error', 'Primero debes completar tu información personal.');
        }

        // Calculate capacity validation
        $interestRate = 0.15;
        $monthlyRate = $interestRate / 12;
        $monthlyPayment = ($request->amount * $monthlyRate * pow(1 + $monthlyRate, $request->term_months)) / 
                         (pow(1 + $monthlyRate, $request->term_months) - 1);
        
        $availableIncome = $client->income - $client->expenses;
        
        if ($monthlyPayment > $availableIncome) {
            return back()->withErrors([
                'amount' => 'El monto solicitado excede tu capacidad de pago. Tu cuota mensual sería $' . number_format($monthlyPayment, 2) . ' pero solo tienes $' . number_format($availableIncome, 2) . ' disponibles.'
            ])->withInput();
        }

        $application = $client->loanApplications()
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (!$application) {
            $application = LoanApplication::create([
                'client_id' => $client->id,
                'amount' => $request->amount,
                'term_months' => $request->term_months,
                'purpose' => $request->purpose,
                'status' => 'draft',
                'loan_data' => null,
            ]);
        } else {
            $application->update([
                'amount' => $request->amount,
                'term_months' => $request->term_months,
                'purpose' => $request->purpose,
            ]);
        }

        return redirect()->route('client.loan-application.step3')
            ->with('success', 'Detalles del préstamo guardados correctamente.');
    }

    /**
     * Show step 3: Review and Submit
     */
    public function step3(Request $request): View
    {
        $user = $request->user();
        $client = $user->client;

        $application = $client->loanApplications()
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (!$application) {
            return redirect()->route('client.loan-application.step1');
        }

        // Calculate estimated monthly payment
        $interestRate = 0.15; // 15% annual
        $monthlyRate = $interestRate / 12;
        $monthlyPayment = ($application->amount * $monthlyRate * pow(1 + $monthlyRate, $application->term_months)) / 
                         (pow(1 + $monthlyRate, $application->term_months) - 1);

        return view('client.loan-application.step3', compact('client', 'application', 'monthlyPayment'));
    }

    /**
     * Show step 4: Documents Upload
     */
    public function step4(Request $request): View
    {
        $user = $request->user();
        $client = $user->client;

        $application = $client->loanApplications()
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (!$application) {
            return redirect()->route('client.loan-application.step1')
                ->with('error', 'No se encontró una solicitud en proceso.');
        }

        // Get existing documents
        $documents = $client->documents()->get()->keyBy('document_type');
        
        $requiredDocuments = [
            'identity' => 'Documento de Identidad o Pasaporte',
            'bank_statement' => 'Estado de Cuenta Bancario (último mes)',
            'employment_proof' => 'Comprobante Laboral (recibo de sueldo o certificado)'
        ];

        return view('client.loan-application.step4', compact('client', 'application', 'documents', 'requiredDocuments'));
    }

    /**
     * Process step 4: Documents Upload
     */
    public function processStep4(Request $request)
    {
        $request->validate([
            'identity' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'bank_statement' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'employment_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'identity.required' => 'El documento de identidad es requerido.',
            'identity.mimes' => 'El documento de identidad debe ser PDF, JPG, JPEG o PNG.',
            'identity.max' => 'El documento de identidad no puede exceder 5MB.',
            'bank_statement.required' => 'El estado de cuenta bancario es requerido.',
            'bank_statement.mimes' => 'El estado de cuenta debe ser PDF, JPG, JPEG o PNG.',
            'bank_statement.max' => 'El estado de cuenta no puede exceder 5MB.',
            'employment_proof.required' => 'El comprobante laboral es requerido.',
            'employment_proof.mimes' => 'El comprobante laboral debe ser PDF, JPG, JPEG o PNG.',
            'employment_proof.max' => 'El comprobante laboral no puede exceder 5MB.',
        ]);

        $user = $request->user();
        $client = $user->client;

        // Validate previous steps are completed
        if (!$client || !$client->employment || !$client->income || !$client->company_name) {
            return redirect()->route('client.loan-application.step1')
                ->with('error', 'Primero debes completar tu información personal.');
        }

        $application = $client->loanApplications()
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (!$application || !$application->amount || !$application->purpose) {
            return redirect()->route('client.loan-application.step2')
                ->with('error', 'Primero debes completar los detalles del préstamo.');
        }

        // Process each document
        $documentTypes = ['identity', 'bank_statement', 'employment_proof'];
        
        foreach ($documentTypes as $docType) {
            if ($request->hasFile($docType)) {
                $file = $request->file($docType);
                
                // Store file
                $fileName = $client->id . '_' . $docType . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('documents/' . $client->id, $fileName, 'private');
                
                // Delete existing document of this type
                $existingDoc = $client->documents()->where('document_type', $docType)->first();
                if ($existingDoc) {
                    Storage::disk('private')->delete($existingDoc->file_path);
                    $existingDoc->delete();
                }
                
                // Create new document record
                ClientDocument::create([
                    'client_id' => $client->id,
                    'document_type' => $docType,
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'status' => 'pending',
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('client.loan-application.review')
            ->with('success', 'Documentos cargados exitosamente. Ahora puedes revisar y enviar tu solicitud.');
    }

    /**
     * Show final review before submission
     */
    public function review(Request $request): View
    {
        $user = $request->user();
        $client = $user->client;

        $application = $client->loanApplications()
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (!$application) {
            return redirect()->route('client.loan-application.step1')
                ->with('error', 'No se encontró una solicitud en proceso.');
        }

        // Calculate estimated monthly payment
        $interestRate = 0.15; // 15% annual
        $monthlyRate = $interestRate / 12;
        $monthlyPayment = ($application->amount * $monthlyRate * pow(1 + $monthlyRate, $application->term_months)) / 
                         (pow(1 + $monthlyRate, $application->term_months) - 1);

        // Get documents
        $documents = $client->documents()->get()->keyBy('document_type');

        return view('client.loan-application.review', compact('client', 'application', 'monthlyPayment', 'documents'));
    }

    /**
     * Submit the loan application
     */
    public function submit(Request $request)
    {
        $user = $request->user();
        $client = $user->client;

        $application = $client->loanApplications()
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (!$application) {
            return redirect()->route('client.loan-application.step1')
                ->with('error', 'No se encontró una solicitud en proceso.');
        }

        // Validate all required documents are uploaded
        $requiredDocuments = ['identity', 'bank_statement', 'employment_proof'];
        $uploadedDocuments = $client->documents()->whereIn('document_type', $requiredDocuments)->pluck('document_type')->toArray();
        
        $missingDocuments = array_diff($requiredDocuments, $uploadedDocuments);
        
        if (!empty($missingDocuments)) {
            $documentNames = [
                'identity' => 'Documento de Identidad',
                'bank_statement' => 'Estado de Cuenta Bancario',
                'employment_proof' => 'Comprobante Laboral'
            ];
            
            $missingNames = array_map(fn($doc) => $documentNames[$doc], $missingDocuments);
            
            return redirect()->route('client.loan-application.review')
                ->with('error', 'Faltan los siguientes documentos: ' . implode(', ', $missingNames));
        }

        $application->update([
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return redirect()->route('client.dashboard')
            ->with('success', '¡Solicitud enviada exitosamente! Te contactaremos pronto con el resultado de la evaluación.');
    }
}