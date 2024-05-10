<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalaosTable extends Migration
{
    public function up()
    {
        Schema::create('galaos', function (Blueprint $table) {
            $table->id();
            $table->decimal('volume', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('galaos');
    }
}
