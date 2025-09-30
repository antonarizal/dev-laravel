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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('id_unit', 10); 
            $table->string('location', 20); 
            $table->unsignedBigInteger('merk_id'); 
            $table->unsignedBigInteger('model_id'); 
            $table->unsignedBigInteger('type_id'); 
            $table->unsignedBigInteger('capacity_id'); 
            $table->unsignedBigInteger('type_refrigrant_id'); 
            $table->unsignedBigInteger('pipa_refrigrant_id');
            $table->string('no_seri', 50);
            $table->integer('year_installation');
            $table->text('indoor_unit');
            $table->text('outdoor_unit');
            $table->timestamps();

            $table->foreign('merk_id')->references('id')->on('merks')->onDelete('cascade');
            $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->foreign('capacity_id')->references('id')->on('capacities')->onDelete('cascade');
            $table->foreign('type_refrigrant_id')->references('id')->on('type_refrigrants')->onDelete('cascade');
            $table->foreign('pipa_refrigrant_id')->references('id')->on('pipa_refrigrants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
