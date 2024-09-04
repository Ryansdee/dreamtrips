<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestsTable extends Migration
{
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('entry_fee', 8, 2)->default(0.00); // Prix d'inscription
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contests');
    }
}
