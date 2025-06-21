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
       Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->string('name', 150); // اسم المهمة
            $table->text('description')->nullable(); // وصف المهمة

            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])
                  ->default('pending')
                  ->index(); // حالة المهمة مع فهرسة

            $table->enum('priority', ['low', 'medium', 'high'])->default('medium'); // أولوية المهمة

            $table->datetime('due_date')->nullable(); // تاريخ الاستحقاق

            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->index(); // المستخدم المسؤول

            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete(); // المستخدم المنشئ

            // يمكن إضافة هذا إذا أردت تتبع التعديلات:
            // $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes(); // حذف ناعم
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
