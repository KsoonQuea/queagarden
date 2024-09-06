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
        Schema::create('contact_person', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email")->nullable();
            $table->string("phone");
            $table->smallInteger("role");
            $table->foreignId('distributor_id')->constrained('distributors')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_person');
    }
};
