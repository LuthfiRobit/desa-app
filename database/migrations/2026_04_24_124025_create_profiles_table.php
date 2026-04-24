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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('village_name');
            $table->string('head_of_village_name')->nullable();
            $table->text('head_of_village_msg')->nullable();
            $table->string('head_of_village_img')->nullable();
            $table->integer('population')->default(0);
            $table->string('area_size')->nullable();
            $table->integer('hamlet_count')->default(0);
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('history')->nullable();
            $table->string('org_chart_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
