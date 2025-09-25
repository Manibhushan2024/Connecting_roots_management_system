@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Patient Details</h1>

    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> {{ $patient->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $patient->email }}</li>
        <li class="list-group-item"><strong>Phone:</strong> {{ $patient->phone }}</li>
        <li class="list-group-item"><strong>Address:</strong> {{ $patient->address }}</li>
        <li class="list-group-item"><strong>Date of Birth:</strong> {{ $patient->date_of_birth }}</li>
        <li class="list-group-item"><strong>Gender:</strong> {{ $patient->gender }}</li>
        <li class="list-group-item"><strong>Medical History:</strong> {{ $patient->medical_history }}</li>
    </ul>

    <a href="{{ route('patients.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
