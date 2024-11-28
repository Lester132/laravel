<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the 'name' column if it exists
            $table->dropColumn('name');

            // Add the new columns for first name, middle name, and last name
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback changes
            $table->string('name');

            // Drop the new columns
            $table->dropColumn(['first_name', 'middle_name', 'last_name']);
        });
    }
};
