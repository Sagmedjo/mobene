<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('energy_consultation_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->integer('post_code');
            $table->longText('bullet_list')->nullable();
            $table->string('building_type');
            $table->integer('units')->nullable();
            $table->integer('construction_year');
            $table->float('area');
            $table->boolean('has_roof_insulation');
            $table->string('window_material');
            $table->string('window_glazing');
            $table->boolean('house_wall_has_insulation');
            $table->string('house_wall_insulation_material')->nullable();
            $table->string('energy_certificate')->nullable();
            $table->string('oil_invoices')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('energy_consultation_inquiries');
    }
};
