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
            $table ->integer("C1")->default(1);
            $table ->integer("C2")->default(1);
            $table ->integer("C3")->default(1);
            $table ->integer("C4")->default(1);
            $table ->integer("C5")->default(1);
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
