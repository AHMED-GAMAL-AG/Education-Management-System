<?php

use App\Models\Diploma;
use App\Models\StudyPlan;
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
        Schema::create('diploma_study_plan', function (Blueprint $table) {
            $table->foreignIdFor(Diploma::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(StudyPlan::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diploma_study_plan');
    }
};
