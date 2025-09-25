@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Patients</h1>
    <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Add New Patient</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patients as $patient)
            <tr>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->phone }}</td>
                <td>
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this patient?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4">No patients yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
