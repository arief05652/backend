<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('table', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 20)->index();
            $table->integer('capacity');
            $table->enum('status', ['tersedia', 'maintenance', 'booking', 'hidden'])
                ->default('hidden')->index();
        });

        Schema::create('log_reservation', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('code', 20);
            $table->text('notes')->nullable();
            $table->integer('capacity');
            $table->enum('status', ['complete', 'cancelled'])->index();
            $table->timestamp('reserve_at');
        });

        Schema::create('reservation', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('table_id')->constrained('table')->onDelete('cascade');
            $table->enum('status', ['waiting', 'active', 'checked_in', 'complete', 'cancelled'])
            ->default('waiting')->index();
            $table->text('notes')->nullable();
            $table->dateTime('schedule');
            $table->integer('capacity');
            $table->timestamp('reserve_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation');
        Schema::dropIfExists('log_reservation');
        Schema::dropIfExists('table');
    }
};
