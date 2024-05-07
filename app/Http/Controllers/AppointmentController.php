<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::all();
        return view('appointments.index', compact('appointments'));
    }

    public function fetchAppointment(){
        $appointments = Appointment::all();
        $array = [];
        foreach ($appointments as $key => $apt) {
           $array[$key]['id'] = $apt->id;
           $array[$key]['title'] = $apt->patient->lastname .' '. $apt->patient->firstname;
           $array[$key]['start'] = $apt->appointment_time;
           $array[$key]['firstname'] = $apt->patient->firstname;
           $array[$key]['lastname'] = $apt->patient->lastname;
        }
        return response()->json($array);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $users = User::where('title', 'Doctor')->get();
        return view('appointments.create', compact('users', 'patients'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $checkPermission = $this->checkPermission(auth()->user()->id, 'créer une demande de dépense');
            if ($checkPermission == false) {
                Log::channel('gestion_facturation_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer une requete de dépenses sans succès');
                return redirect()->back()->with('errors', "Vous n'avez pas la permission d'Enregistrer une demande de dépense.");
            }

            // dd($request->file('justificatif_req'));

            $validator = Validator::make($request->only(['notes', 'patient', 'appointment_time']), [
                // 'label_categorie' => ['required', 'string'],
                'notes' => ['required', 'string'],
                'appointment_time' => ['required', 'string'],
                'patient' => ['required', 'numeric'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }
           
            $appointment = Appointment::create([
                'patient_id' => $request->patient,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
                'user_id' => auth()->user()->id
            ]);

            if ($appointment) {

                Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a créé un rendez-vous');

                return redirect()->route('appointments.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de créer un rendez-vous sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
