<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGarrafasTable extends Migration
{
    public function up()
    {
        Schema::create('garrafas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('galao_id')->constrained()->onDelete('cascade');
            $table->decimal('volume', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('garrafas');
    }
}
