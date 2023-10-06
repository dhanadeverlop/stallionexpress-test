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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->text('uuid')->nullable();
            $table->integer('property_type_id')->nullable();
            $table->text('county');
            $table->text('country');
            $table->text('town');
            $table->text('postcode')->nullable();
            $table->longText('description');
            $table->text('address');
            $table->string('image_full')->nullable();
            $table->string('image_thumbnail')->nullable();
            $table->decimal('latitude',10,8)->default(0);
            $table->decimal('longitude',11,8)->default(0);
            $table->integer('num_bedrooms')->default(0);
            $table->integer('num_bathrooms')->default(0);
            $table->float('price')->default(0);
            $table->text('type');
            $table->json('property_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
