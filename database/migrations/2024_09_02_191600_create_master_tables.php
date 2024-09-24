<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTables extends Migration
{
    // public function up()
    // {
    //     // Create the office table first
    //     Schema::create('office', function (Blueprint $table) {
    //         $table->id(); // This creates an auto-incrementing primary key column named 'id'
    //         $table->string('office_name');
    //         $table->text('desc')->nullable();
    //         $table->string('db_name_users')->unique();
    //         $table->enum('status', ['default', 'custom', 'inactive'])->default('default');
    //         $table->string('host')->nullable(); // Host of the database
    //         $table->integer('port')->nullable(); // Port of the database
    //         $table->string('username')->nullable(); // Username for the database connection
    //         $table->string('password')->nullable(); // Password for the database connection
    //         $table->timestamps();
    //     });

    //     // Now create the users table with a foreign key reference to the office table
    //     Schema::create('users', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('username');
    //         $table->string('email')->unique();
    //         $table->foreignId('office_id')->constrained('office'); // This adds the foreign key constraint
    //         $table->timestamps();
    //     });
    // }


    // public function down()
    // {
    //     Schema::dropIfExists('users');
    //     Schema::dropIfExists('office');
    // }
}
