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
            $table->string('system_code')->unique(); // Format: 07070202-0001-01
            $table->string('family_code'); // Family code within the village
            
            // Location hierarchy
            $table->foreignId('province_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->foreignId('district_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->foreignId('commune_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->foreignId('village_id')->nullable()->constrained('locations')->onDelete('set null');
            
            // Member Information
            $table->string('full_name');
            $table->string('photo')->nullable();
            $table->date('birth_date');
            $table->integer('age_years')->nullable();
            $table->integer('age_months')->nullable();
            $table->string('gender'); // Will use Gender enum
            $table->string('id_card_number')->nullable();
            $table->string('id_card_status')->nullable(); // Will use IdCardStatus enum
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            
            // Family Relationship
            $table->string('relationship_type'); // Will use RelationshipType enum
            $table->string('life_status')->default('រស់'); // Will use LifeStatus enum
            $table->foreignId('related_to_member_id')->nullable()->constrained('family_members')->onDelete('set null');
            
            // Party Information
            $table->date('party_join_date')->nullable();
            $table->string('party_member_number')->nullable();
            $table->boolean('is_party_member')->default(false);
            
            // Occupation
            $table->string('work_location')->nullable(); // Will use WorkLocation enum
            $table->string('occupation')->nullable(); // Will use Occupation enum
            $table->string('work_address')->nullable();
            
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
