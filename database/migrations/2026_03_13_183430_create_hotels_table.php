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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id(); // id column
            $table->string('hotel_name'); // hotel name
            $table->text('address'); // hotel address
            $table->string('contact_no'); // contact number
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at column for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
