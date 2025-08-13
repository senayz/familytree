<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       Schema::create('family_relationships', function (Blueprint $table) {
    $table->id();
    $table->foreignId('member1_id')->constrained('family_members')->onDelete('cascade');
    $table->foreignId('member2_id')->constrained('family_members')->onDelete('cascade');
    $table->enum('relationship_type', ['parent', 'child', 'spouse', 'sibling']);
    $table->timestamps();

    // Use a shorter name for the unique constraint
    $table->unique(['member1_id', 'member2_id', 'relationship_type'], 'family_rel_unique');
});
    }

    public function down()
    {
        Schema::dropIfExists('family_relationships');
    }
};