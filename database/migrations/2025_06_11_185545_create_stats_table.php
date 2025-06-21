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
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('total_customers')->default(0);
            $table->unsignedMediumInteger('team_members')->default(0);
            $table->unsignedMediumInteger('active_tasks')->default(0);
            $table->unsignedMediumInteger('total_documents')->default(0);
            $table->unsignedMediumInteger('uploads_this_month')->default(0);
            $table->date('record_date')->unique();
            $table->timestamps();

            $table->index('record_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
