<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultations = Consultation::all();
        return view('consultations.index', compact('consultations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        return view('consultations.create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Enregistrer une dépense');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission d'Enregistrer une dépense.");
            }

            // Validator::extend('custom_file_type', function ($attribute, $value, $parameters, $validator) {
            //     // Define allowed MIME types for images and documents
            //     $allowedMimeTypes = [
            //         'image/jpeg',
            //         'image/png',
            //         'image/gif',
            //         'application/pdf',
            //         'application/msword',
            //         'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // for .docx
            //     ];

            //     // Get the MIME type of the file
            //     $fileMimeType = $value->getClientMimeType();

            //     // Check if the MIME type is in the list of allowed MIME types
            //     return in_array($fileMimeType, $allowedMimeTypes);
            // });

            $validator = Validator::make($request->only(['ordonnance', 'patient', 'etatpaiement', 'traitements', 'examens', 'diagnostic', 'motif', 'montant']), [
                'patient' => ['required', 'string'],
                'etatpaiement' => ['required', 'string'],
                'traitements' => ['nullable', 'string'],
                'examens' => ['nullable', 'string'],
                'ordonnance' => ['nullable', 'string'],
                'motif' => ['required', 'string'],
                'diagnostic' => ['nullable', 'string'],
                'montant' => ['required', 'numeric'],
                // 'justificatif' => 'required|file|custom_file_type'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            // $path = $request->file('justificatif')->store('depenses', 'public');
            $consultation = Consultation::create([
                'patient_id' => $request->patient,
                'etatpaiement' => $request->etatpaiement,
                'traitements' => $request->traitements,
                'examens' => $request->examens,
                'diagnostic' => $request->diagnostic,
                'ordonnance' => $request->ordonnance,
                'motif' => $request->motif,
                'montant' => $request->montant,

            ]);


            if ($consultation) {
                $payment = Payment::create([
                    'type_paiement' => 'Consultation',
                    'type_id' => $consultation->id,
                    'patient_id' => $consultation->patient_id,
                    'montant' => $request->montant
                ]);
                Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a effectué une consultation');
                return redirect()->route('consultations.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé d\'enregistrer une consultation sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultation $consultation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultation $consultation)
    {
        $patients = Patient::all();
        return view('consultations.create', compact('patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Enregistrer une dépense');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission d'Enregistrer une dépense.");
            }

            // Validator::extend('custom_file_type', function ($attribute, $value, $parameters, $validator) {
            //     // Define allowed MIME types for images and documents
            //     $allowedMimeTypes = [
            //         'image/jpeg',
            //         'image/png',
            //         'image/gif',
            //         'application/pdf',
            //         'application/msword',
            //         'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // for .docx
            //     ];

            //     // Get the MIME type of the file
            //     $fileMimeType = $value->getClientMimeType();

            //     // Check if the MIME type is in the list of allowed MIME types
            //     return in_array($fileMimeType, $allowedMimeTypes);
            // });

            $validator = Validator::make($request->only(['ordonnance', 'patient', 'etatpaiement', 'traitements', 'examens', 'diagnostic', 'motif', 'montant']), [
                'patient' => ['required', 'string'],
                'etatpaiement' => ['required', 'string'],
                'traitements' => ['nullable', 'string'],
                'examens' => ['nullable', 'string'],
                'ordonnance' => ['nullable', 'string'],
                'motif' => ['required', 'string'],
                'diagnostic' => ['nullable', 'string'],
                'montant' => ['required', 'numeric'],
                // 'justificatif' => 'required|file|custom_file_type'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            // $path = $request->file('justificatif')->store('depenses', 'public');
            $consultation = Consultation::findOrFail($id)->update([
                'patient_id' => $request->patient,
                'etatpaiement' => $request->etatpaiement,
                'traitements' => $request->traitements,
                'examens' => $request->examens,
                'diagnostic' => $request->diagnostic,
                'ordonnance' => $request->ordonnance,
                'motif' => $request->motif,
                'montant' => $request->montant,

            ]);


            if ($consultation) {
                Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifié une consultation');
                return redirect()->route('consultations.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de modifier une consultation sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultation $consultation)
    {
        //
    }
}
