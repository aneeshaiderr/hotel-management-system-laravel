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
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // id column
            $table->string('service_name'); // service_name column
            $table->string('status'); // status column
            $table->decimal('price', 10, 2); // price column, max 10 digits, 2 decimal places
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at column for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
