<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('valor', 10, 2);
            $table->string('cor');
            $table->integer('quantidade');
            $table->string('imagem')->nullable();
            $table->timestamps();
        });
    } 

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
} 
