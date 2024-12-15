<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Add the 'status' column with the default value as 'new'
            $table->enum('status', ['new', 'pending', 'completed', 'canceled'])->default('new');
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop the 'status' column if the migration is rolled back
            $table->dropColumn('status');
        });
    }
}
