<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('family_members', function (Blueprint $table) {
    $table->id();
    $table->string('first_name');
    $table->string('last_name');
    $table->string('middle_name')->nullable();
    $table->date('birth_date')->nullable();
    $table->date('death_date')->nullable();
    $table->enum('gender', ['male', 'female', 'other']);
    $table->text('bio')->nullable();
    $table->string('photo_path')->nullable();
    $table->string('role')->nullable(); // Founder, Branch Head, etc.
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
