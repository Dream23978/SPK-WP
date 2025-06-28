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
        Schema::create('alterskor', function (Blueprint $table) {
            $table->id();
            $table ->string("kode_alternatif")->nullable();
            $table ->string("nama_alternatif")->nullable();
            $table ->integer("C1")->default();
            $table ->integer("C2")->default();
            $table ->integer("C3")->default();
            $table ->integer("C4")->default();
            $table ->integer("C5")->default();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alterskor');
    }
};
