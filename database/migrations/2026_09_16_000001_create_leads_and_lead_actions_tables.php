<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table): void {
            $table->id();
            $table->string('type', 32)->index(); // 'investor', 'startup'
            $table->string('sub_type', 64)->index(); // 'corporate', 'msme', 'family_office', 'hni', 'msme_startup', 'newway_startup'
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile_no', 32)->nullable();
            $table->string('company')->nullable();
            $table->text('information')->nullable();
            $table->string('source')->nullable(); // lead generated through
            $table->timestamps();
        });

        Schema::create('lead_actions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->string('action');
            $table->string('timeline')->nullable();
            $table->string('state', 32)->default('In Progress')->index(); // 'In Progress', 'Complete'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_actions');
        Schema::dropIfExists('leads');
    }
};
