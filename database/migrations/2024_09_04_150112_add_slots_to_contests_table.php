<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->integer('total_slots')->default(252); // Total slots available
            $table->integer('occupied_slots')->default(0); // Slots currently occupied
        });
    }
    
    public function down()
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->dropColumn('total_slots');
            $table->dropColumn('occupied_slots');
        });
    }
};
