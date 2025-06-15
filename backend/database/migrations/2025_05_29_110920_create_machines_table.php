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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->foreignId('type_id')->constrained('machine_types')->restrictOnDelete();
            $table->foreignId('category_id')->constrained('machine_categories')->restrictOnDelete();
            $table->string('machine_model', 200);
            $table->string('serial_number', 100);
            $table->string('manufacturer', 200);
            $table->foreignId('location_id')->constrained('locations')->restrictOnDelete();
            $table->text('description')->nullable();
            $table->date('install_date')->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->string('supplier', 200)->nullable();
            $table->integer('operating_temperature_min')->nullable();
            $table->integer('operating_temperature_max')->nullable();
            $table->decimal('operating_pressure_max', 8, 2)->nullable();
            $table->decimal('power_consumption', 8, 2)->nullable();
            $table->integer('voltage')->nullable();
            $table->integer('frequency')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('dimensions', 100)->nullable();
            $table->integer('maintenance_interval_days')->nullable();
            $table->enum('status', ['operational', 'maintenance', 'warning', 'critical', 'retired'])->default('operational');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
