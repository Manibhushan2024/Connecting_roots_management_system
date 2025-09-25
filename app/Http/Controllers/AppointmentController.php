<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('patient')->orderBy('start_datetime', 'desc')->get();
        return view('appointments.index', compact('appointments'));
    }

    public function createPublic()
    {
        return view('appointments.create-public');
    }

    public function storePublic(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'mode' => 'required|in:online,offline',
        ]);

        // Find or create patient
        $patient = Patient::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name']]
        );

        $start = Carbon::parse($data['appointment_date'] . ' ' . $data['appointment_time']);
        $end = $start->copy()->addHour(); // Default 1 hour duration

        // Check for conflicts (including 15-minute buffer)
        $conflict = $this->checkAppointmentConflict($start, $end);
        
        if ($conflict) {
            return redirect()->back()->withErrors([
                'appointment_time' => 'This time slot is not available. Please choose a different time.'
            ])->withInput();
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'start_datetime' => $start,
            'end_datetime' => $end,
            'duration_minutes' => 60,
            'mode' => $data['mode'],
            'meet_link' => $data['mode'] == 'online' ? 'https://meet.google.com/' . uniqid() : null,
            'status' => 'pending',
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully!');
    }

    public function create()
    {
        $patients = Patient::all();
        return view('appointments.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            'time' => 'required',
            'mode' => 'required|in:online,offline',
        ]);

        $start = Carbon::parse($data['date'] . ' ' . $data['time']);
        $end = $start->copy()->addHour(); // Default 1 hour duration

        // Check for conflicts (including 15-minute buffer)
        $conflict = $this->checkAppointmentConflict($start, $end);
        
        if ($conflict) {
            return redirect()->back()->withErrors([
                'time' => 'This time slot is not available. Please choose a different time.'
            ])->withInput();
        }

        Appointment::create([
            'patient_id' => $data['patient_id'],
            'start_datetime' => $start,
            'end_datetime' => $end,
            'duration_minutes' => 60,
            'mode' => $data['mode'],
            'meet_link' => $data['mode'] == 'online' ? 'https://meet.google.com/' . uniqid() : null,
            'status' => 'pending',
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully!');
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        return view('appointments.edit', compact('appointment', 'patients'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            'time' => 'required',
            'duration_minutes' => 'required|integer|min:15',
            'mode' => 'required|in:online,offline',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $start = Carbon::parse($data['date'] . ' ' . $data['time']);
        $end = $start->copy()->addMinutes($data['duration_minutes']);

        // Check for conflicts (excluding current appointment)
        $conflict = Appointment::where('id', '!=', $appointment->id)
            ->where(function ($query) use ($start, $end) {
                $bufferStart = $start->copy()->subMinutes(15);
                $bufferEnd = $end->copy()->addMinutes(15);
                
                $query->whereBetween('start_datetime', [$bufferStart, $bufferEnd])
                      ->orWhereBetween('end_datetime', [$bufferStart, $bufferEnd])
                      ->orWhere(function ($q) use ($bufferStart, $bufferEnd) {
                          $q->where('start_datetime', '<=', $bufferStart)
                            ->where('end_datetime', '>=', $bufferEnd);
                      });
            })->where('status', '!=', 'cancelled')->exists();
        
        if ($conflict) {
            return redirect()->back()->withErrors([
                'time' => 'This time slot conflicts with another appointment. Please choose a different time.'
            ])->withInput();
        }

        $appointment->update([
            'patient_id' => $data['patient_id'],
            'start_datetime' => $start,
            'end_datetime' => $end,
            'duration_minutes' => $data['duration_minutes'],
            'mode' => $data['mode'],
            'status' => $data['status'],
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully!');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully!');
    }

    /**
     * Check for appointment conflicts with 15-minute buffer
     */
    private function checkAppointmentConflict($start, $end)
    {
        // Add 15-minute buffer before and after
        $bufferStart = $start->copy()->subMinutes(15);
        $bufferEnd = $end->copy()->addMinutes(15);

        return Appointment::where(function ($query) use ($bufferStart, $bufferEnd) {
            $query->whereBetween('start_datetime', [$bufferStart, $bufferEnd])
                  ->orWhereBetween('end_datetime', [$bufferStart, $bufferEnd])
                  ->orWhere(function ($q) use ($bufferStart, $bufferEnd) {
                      $q->where('start_datetime', '<=', $bufferStart)
                        ->where('end_datetime', '>=', $bufferEnd);
                  });
        })->where('status', '!=', 'cancelled')->exists();
    }
}