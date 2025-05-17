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
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('menu_name', 255)->index();
            $table->decimal('price', 10, 2);
            $table->text('picture');
            $table->enum('category', ['appetizers', 'main_course', 'drinks', 'side_dishes'])->index();
            $table->enum('status', ['out_of_stock', 'available']);
        });

        Schema::create('order', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('menu_id')->constrained('menus')->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('notes', 255)->nullable();
            $table->enum('status', ['pending', 'preparing', 'ready'])->default('pending');
            $table->timestamp('order_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('orders');
    }
};
