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
        Schema::create('simple_family_members', function (Blueprint $table) {
            $table->id();
            
            // I. Member Information
            $table->string('system_code')->unique(); // (07070202-0001-01)
            $table->string('full_name'); // នាម និងគោត្តនាម
            $table->string('photo')->nullable(); // រូបថត
            $table->date('birth_date'); // ថ្ងៃខែឆ្នាំកំណើត
            $table->integer('age_years')->nullable(); // អាយុ ឆ្នាំ
            $table->integer('age_months')->nullable(); // អាយុ ខែ
            $table->string('gender'); // ភេទ (ប្រុស/ស្រី)
            $table->string('id_card_number')->nullable(); // លេខអត្តសញ្ញាណបណ្ណ
            $table->string('id_card_status')->nullable(); // សុពលភាព (មាន/ពុំទាន់មាន/បាត់)
            $table->text('address')->nullable(); // អាសយដ្ឋាន
            $table->string('phone_number')->nullable(); // លេខទំនាក់ទំនង
            
            // II. Family Information - Father (ឪពុក)
            $table->string('father_status')->nullable(); // (រស់/ស្លាប់)
            $table->string('father_name')->nullable(); // នាម និងគោត្តនាម
            $table->string('father_photo')->nullable(); // រូបថត
            $table->date('father_birth_date')->nullable(); // ថ្ងៃខែឆ្នាំកំណើត
            $table->integer('father_age_years')->nullable(); // អាយុ ឆ្នាំ
            $table->integer('father_age_months')->nullable(); // អាយុ ខែ
            $table->string('father_system_code')->nullable(); // លេខក្នុងប្រព័ន្ធ
            
            // Family Information - Mother (ម្តាយ)
            $table->string('mother_status')->nullable(); // (រស់/ស្លាប់)
            $table->string('mother_name')->nullable(); // នាម និងគោត្តនាម
            $table->string('mother_photo')->nullable(); // រូបថត
            $table->date('mother_birth_date')->nullable(); // ថ្ងៃខែឆ្នាំកំណើត
            $table->integer('mother_age_years')->nullable(); // អាយុ ឆ្នាំ
            $table->integer('mother_age_months')->nullable(); // អាយុ ខែ
            $table->string('mother_system_code')->nullable(); // លេខក្នុងប្រព័ន្ធ
            
            // Family Information - Siblings (បងប្អូន) - JSON for multiple
            $table->json('siblings')->nullable(); // Array of sibling data
            
            // Family Information - Children (កូន) - JSON for multiple
            $table->json('children')->nullable(); // Array of children data
            
            // III. Party Information (ព័ត៌មានក្នុងបក្ស)
            $table->date('party_join_date')->nullable(); // កាលបរិច្ឆេទចូលជាសមាជិក
            $table->string('party_member_number')->nullable(); // លេខសមាជិក
            $table->boolean('is_party_member')->default(false);
            
            // IV. Occupation (មុខរបរ)
            $table->string('work_location')->nullable(); // ទីកន្លែង
            $table->string('occupation')->nullable(); // មុខរបរ
            $table->text('work_address')->nullable(); // អាសយដ្ឋានកន្លែងធ្វើការ
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simple_family_members');
    }
};
