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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id(); // id column
            $table->string('hotel_code'); // hotel code
            $table->unsignedBigInteger('user_id'); // foreign key to users
            $table->unsignedBigInteger('guest_id'); // foreign key to guests
            $table->unsignedBigInteger('hotel_id'); // foreign key to hotels
            $table->unsignedBigInteger('room_id'); // foreign key to rooms
            $table->unsignedBigInteger('staff_id')->nullable(); // foreign key to staff, optional
            $table->unsignedBigInteger('discount_id')->nullable(); // foreign key to discounts, optional
            $table->date('check_in'); // check-in date
            $table->date('check_out'); // check-out date
            $table->string('status')->default('pending'); // status (pending, confirmed, cancelled)
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at for soft deletes

            // Optional: foreign key constraints
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
            // $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            // $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            // $table->foreign('staff_id')->references('id')->on('staff')->onDelete('set null');
            // $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
