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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 20)->unique();
            $table->string('title', 200);
            
            $table->enum('type', [
                'corrective',
                'preventive',
                'predictive',
                'inspection',
                'improvement',
                'legal',
                'installation',
                'cleaning',
            ]);

            $table->text('description');

            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'canceled'])->default('pending');

            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->foreignId('location_id')->constrained('locations')->restrictOnDelete();

            $table->timestamp('due_at');
            $table->timestamp('paused_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('resumed_at')->nullable();

            $table->decimal('estimated_hours', 5, 2);
            $table->decimal('actual_hours', 5, 2)->nullable();

            $table->string('requested_by', 200)->nullable();
            $table->string('approved_by', 200)->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
