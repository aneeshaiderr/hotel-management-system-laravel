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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id(); // id column
            $table->string('name')->unique(); // permission name, unique to avoid duplicates
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at column for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
