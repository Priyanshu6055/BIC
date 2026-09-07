<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table): void {
            $table->id();
            $table->string('reference')->unique();
            $table->string('type', 32)->index();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 32);
            $table->string('company')->nullable();
            $table->json('payload');
            $table->string('document_path')->nullable();
            $table->string('status', 32)->default('New')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};

