<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Link to patients table (explicit foreign key)
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');

            // Start & End time for easy conflict checking
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');

            // Online/Offline
            $table->enum('mode', ['online', 'offline'])->default('offline');
            $table->string('meet_link')->nullable();

            // Status of appointment
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');

            $table->timestamps();

            // Optional: Index for faster conflict checks
            $table->index(['start_datetime', 'end_datetime']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
