@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Patient</h1>

    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('patients.partials.form', ['submitText' => 'Update'])
    </form>
</div>
@endsection
