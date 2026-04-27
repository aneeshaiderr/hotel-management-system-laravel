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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id(); // id column
            $table->string('discount_type'); // type of discount (e.g., percentage, flat)
            $table->string('discount_name'); // discount name
            $table->decimal('value', 10, 2); // discount value
            $table->date('start_date'); // start date
            $table->date('end_date'); // end date
            $table->string('status')->default('active'); // status (active, inactive)
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at column for soft deletes
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount');
    }
};
