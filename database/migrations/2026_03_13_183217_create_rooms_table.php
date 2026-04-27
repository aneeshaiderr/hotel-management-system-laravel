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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); // id column
            $table->unsignedBigInteger('hotel_id'); // hotel_id column
            $table->string('room_number'); // room_number column
            $table->integer('floor'); // floor column
            $table->string('status'); // status column (e.g., available, occupied)
            $table->integer('beds'); // beds column
            $table->integer('max_guests'); // max_guests column
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at column for soft deletes

            // Optional: foreign key constraint if hotels table exists
            // $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
