<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Consultation;
use App\Models\Country;
use App\Models\Patient;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        return view('patients.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            // dd($request);
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Enregistrer une dépense');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission d'Enregistrer une dépense.");
            }

            Validator::extend('custom_photo_type', function ($attribute, $value, $parameters, $validator) {
                // Define allowed MIME types for images and documents
                $allowedMimeTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                ];

                // Get the MIME type of the file
                $fileMimeType = $value->getClientMimeType();

                // Check if the MIME type is in the list of allowed MIME types
                return in_array($fileMimeType, $allowedMimeTypes);
            });

            $validator = Validator::make($request->all(), [
                'lastname' => ['required','string'],
                'middlename' => ['nullable', 'string'],
                'firstname' => ['required', 'string'],
                'gender' => ['nullable', 'string'],
                'city' => ['nullable', 'numeric'],
                'country' => ['nullable', 'numeric'],
                'region' => ['nullable', 'numeric'],
                'occupation' => ['nullable', 'string'],
                'birthdate' => ['nullable', 'string'],
                'phoneNumber' => ['nullable', 'string'],
                'maritalStatus' => ['nullable', 'string'],
                'height' => ['nullable', 'string'],
                'weight' => ['nullable', 'string'],
                'allergies' => ['nullable', 'string'],
                'owndeseases' => ['nullable', 'string'],
                'familydeseases' => ['nullable', 'string'],
                'postalcode' => ['nullable', 'string'],
                'address' => ['nullable', 'string'],
                'childnumber' => ['nullable', 'string'],
                'bloodgroup' => ['nullable', 'string'],
                'civility' => ['nullable', 'string'],
                'photo' => 'nullable|file|custom_photo_type'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $path = $request->hasFile('photo') ? $request->file('photo')->store('photoPatient', 'public') : null;
            $patient = Patient::create([
                'lastname' => $request->lastname,
                'middlename' => $request->middlename,
                'firstname' => $request->firstname,
                'gender' => $request->gender,
                'city' => $request->city,
                'country' => $request->country,
                'region' => $request->region,
                'occupation' => $request->occupation,
                'birthdate' => $request->birthdate,
                'phoneNumber' => $request->phoneNumber,
                'maritalStatus' => $request->maritalStatus,
                'height' => $request->height,
                'weight' => $request->weight,
                'allergies' => $request->allergies,
                'owndeseases' => $request->owndeseases,
                'familydeseases' => $request->familydeseases,
                'postalcode' => $request->postalcode,
                'address' => $request->address,
                'childnumber' => $request->childnumber,
                'bloodgroup' => $request->bloodgroup,
                'civility' => $request->civility,
                'photo' => $path
            ]);

            if ($patient) {
                Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a enregistré un patient');
                return redirect()->route('patients.index');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé d\'enregistrer un patient');
            if (str_contains($th->getMessage() , 'Duplicate entry')) {
                return redirect()->back()->with('errors', 'Ce patient existe déjà');
            }
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // dd($request);
        $checkPermission = $this->checkPermission(auth()->user()->id, 'Voir le dossier d\'un patient');
        if ($checkPermission == false) {
            return redirect()->back()->with('errors', "Vous n'avez pas la permission voir le dossier d'un patient.");
        }
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $patient = Patient::with(['consultations', 'payments', 'appointments'])->where('id', $id)->first();
        $count_consult = count($patient->consultations->toarray());
        $count_paymt = count($patient->payments->toarray());
        $count_rdv = count($patient->appointments->toarray());
        // dd($patient->appointments);
        return view('patients.show', compact('patient', 'countries', 'cities', 'states', 'count_consult', 'count_paymt', 'count_rdv'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient', 'countries', 'cities', 'states'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            // dd($request);
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Enregistrer une dépense');
            if ($checkPermission == false) {
                return redirect()->back()->with('errors', "Vous n'avez pas la permission d'Enregistrer une dépense.");
            }

            Validator::extend('custom_photo_type', function ($attribute, $value, $parameters, $validator) {
                // Define allowed MIME types for images and documents
                $allowedMimeTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                ];

                // Get the MIME type of the file
                $fileMimeType = $value->getClientMimeType();

                // Check if the MIME type is in the list of allowed MIME types
                return in_array($fileMimeType, $allowedMimeTypes);
            });
            $validator = Validator::make($request->only(
                [
                    'lastname',
                    'middlename',
                    'firstname',
                    'gender',
                    'city',
                    'country',
                    'region',
                    'occupation',
                    'birthdate',
                    'phoneNumber',
                    'maritalStatus',
                    'height',
                    'weight',
                    'allergies',
                    'owndeseases',
                    'familydeseases',
                    'postalcode',
                    'address',
                    'childnumber',
                    'bloodgroup',
                    'civility',
                ]
            ), [
                'lastname' => ['required', 'string'],
                'middlename' => ['nullable', 'string'],
                'firstname' => ['required', 'string'],
                'gender' => ['nullable', 'string'],
                'city' => ['nullable', 'numeric'],
                'country' => ['nullable', 'numeric'],
                'region' => ['nullable', 'numeric'],
                'occupation' => ['nullable', 'string'],
                'birthdate' => ['nullable', 'string'],
                'phoneNumber' => ['nullable', 'string'],
                'maritalStatus' => ['nullable', 'string'],
                'height' => ['nullable', 'string'],
                'weight' => ['nullable', 'string'],
                'allergies' => ['nullable', 'string'],
                'owndeseases' => ['nullable', 'string'],
                'familydeseases' => ['nullable', 'string'],
                'postalcode' => ['nullable', 'string'],
                'address' => ['nullable', 'string'],
                'childnumber' => ['nullable', 'string'],
                'bloodgroup' => ['nullable', 'string'],
                'civility' => ['nullable', 'string'],
                'photo' => 'nullable|file|custom_photo_type'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $path = $request->hasFile('photo') ? $request->file('photo')->store('photoPatient', 'public') : null;
            $patient = Patient::findOrFail($id)->update([
                'lastname' => $request->lastname,
                'middlename' => $request->middlename,
                'firstname' => $request->firstname,
                'gender' => $request->gender,
                'city' => $request->city,
                'country' => $request->country,
                'region' => $request->region,
                'occupation' => $request->occupation,
                'birthdate' => $request->birthdate,
                'phoneNumber' => $request->phoneNumber,
                'maritalStatus' => $request->maritalStatus,
                'height' => $request->height,
                'weight' => $request->weight,
                'allergies' => $request->allergies,
                'owndeseases' => $request->owndeseases,
                'familydeseases' => $request->familydeseases,
                'postalcode' => $request->postalcode,
                'address' => $request->address,
                'childnumber' => $request->childnumber,
                'bloodgroup' => $request->bloodgroup,
                'civility' => $request->civility,
                'photo' => $path
            ]);



            if ($patient) {
                Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a modifié un patient');
                return redirect()->route('patients.index');
            }
        } catch (Throwable $th) {
            Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé d\'enregistrer un patient');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $patient = Patient::find($id);
            $checkPermission = $this->checkPermission(auth()->user()->id, 'Supprimer une demande de dépense');
            if ($checkPermission == false) {
                Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer le patient ' . $patient->firstname . ' ' . $patient->lastname . ' sans succès');
                return redirect()->back()->with('errors', "Vous n'avez pas la permission de Supprimer un patient.");
            }

            if ($patient) {
                Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a supprimé le patient ' . $patient->firstname . ' ' . $patient->lastname);
                $patient->delete();
                return redirect()->back()->with('success', 'Patient supprimée avec succes.');
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_patients')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de supprimer le patient ' . $patient->firstname . ' ' . $patient->lastname . ' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    public function fetchState(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }
    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where("state_id", $request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }
    public function fetchPatientsTot(Request $request)
    {
        $data['patients'] = DB::table('patients') // Total des patients du mois
            ->whereBetween('created_at', [$request->dateFrom, $request->datoTo])->count();
        return response()->json($data);
    }

    public function fetchSalesTot(Request $request)
    {
        $data['salestot'] = DB::table('sales') // Total des ventes d'une periode
            ->join('drugs', 'sales.drug_id', 'drugs.id')
            ->whereBetween('sales.sale_date', [$request->dateFrom . ' 00:00:00', $request->dateTo . ' 23:59:59'])
            // ->selectRaw('SUM(quantity * sale_price) as total_sales')
            // ->value('total_sales');
            ->get(['sales.*', 'drugs.name']);
        return response()->json($data);
    }
}
