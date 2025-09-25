@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Patient</h1>

    <form action="{{ route('patients.store') }}" method="POST">
        @csrf
        @include('patients.partials.form', ['submitText' => 'Save'])
    </form>
</div>
@endsection
