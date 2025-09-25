@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Appointment Details</h1>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Patient Information</h5>
                    <p><strong>Name:</strong> {{ $appointment->patient->name }}</p>
                    <p><strong>Email:</strong> {{ $appointment->patient->email }}</p>
                    <p><strong>Phone:</strong> {{ $appointment->patient->phone ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Appointment Details</h5>
                    <p><strong>Date:</strong> {{ $appointment->start_datetime->format('M d, Y') }}</p>
                    <p><strong>Time:</strong> {{ $appointment->start_datetime->format('H:i') }} - {{ $appointment->end_datetime->format('H:i') }}</p>
                    <p><strong>Mode:</strong> <span class="badge bg-{{ $appointment->mode == 'online' ? 'info' : 'secondary' }}">{{ ucfirst($appointment->mode) }}</span></p>
                    <p><strong>Status:</strong> <span class="badge bg-{{ $appointment->status == 'confirmed' ? 'success' : ($appointment->status == 'cancelled' ? 'danger' : 'warning') }}">{{ ucfirst($appointment->status) }}</span></p>
                    @if($appointment->mode == 'online' && $appointment->meet_link)
                        <p><strong>Meeting Link:</strong> <a href="{{ $appointment->meet_link }}" target="_blank">{{ $appointment->meet_link }}</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('appointments.index') }}" class="btn btn-secondary mt-3">Back to Appointments</a>
    <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning mt-3">Edit Appointment</a>
</div>
@endsection