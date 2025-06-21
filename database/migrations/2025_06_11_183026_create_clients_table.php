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
          Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->string('company_name')->index();
            $table->enum('service_type', ['Software', 'Design', 'Marketing', 'Business'])->index();
            $table->string('logo')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
