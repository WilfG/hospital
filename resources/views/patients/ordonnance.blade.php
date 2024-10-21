@extends('layout.documents')

@section('content')
<div class="header">
    <img src="{{asset('assets/img/logo_st_antoine.png')}}" alt="Doctor Logo">
    <h1>Centre de Santé Saint Antoine de PADOUE</h1>
    <p>Médecine Général</p>
    <p>Adresse: Kraké</p>
</div>

<div class="patient-info">
    <h2>Information du patient</h2>
    <table class="info-table">
        <tr>
            <th>Nom</th>
            <td>{{$consultation->patient->lastname}}</td>
        </tr>
        <tr>
            <th>Prénoms</th>
            <td>{{$consultation->patient->firstname}}</td>
        </tr>

    </table>
</div>

<!-- <div class="doctor-info">
    <h2>Doctor Information</h2>
    <table class="info-table">
        <tr>
            <th>Name</th>
            <td>Dr. John Doe</td>
        </tr>
        <tr>
            <th>Specialization</th>
            <td>General Practitioner</td>
        </tr>
        <tr>
            <th>Contact</th>
            <td>(123) 456-7890</td>
        </tr>
    </table>
</div> -->

<div class="prescription-info">
    <h2>Prescription</h2>
    <table class="prescription-items">
        <tr>
            <th>Produits</th>
            <!-- <th>Dosage</th>
            <th>Fréquence</th> -->
        </tr>
        <tr>
            <td>{!!$consultation->ordonnance!!}</td>
            <!-- <td>500 mg</td>
            <td>3 times a day</td> -->
        </tr>
        <!-- <tr>
            <td>Ibuprofen</td>
            <td>200 mg</td>
            <td>2 times a day</td>
        </tr>
        <tr>
            <td>Metformin</td>
            <td>500 mg</td>
            <td>1 time a day</td>
        </tr> -->
    </table>
</div>

<div class="footer">
    <p>&copy; 2024 CSAP. Tous droits réservés.</p>
</div>
<!-- <div class="my-3 mx-3 d-flex justify-content-end">
    <button class="btn btn-primary d-none" id="generate-pdf-btn">Générer format PDF</button>
    <form action="/generate-invoice" method="POST" id="generate-form">
        @csrf
        <input type="hidden" name="body" id="body">
        <input type="hidden" name="consultation_id" value="{{ $consultation->id }}">
    </form>
</div> -->

@endsection