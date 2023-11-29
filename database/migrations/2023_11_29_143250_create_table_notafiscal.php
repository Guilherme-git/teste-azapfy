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
        Schema::create('notafiscal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("id_usuario");
            $table->string('numero');
            $table->double('valor',10.2);
            $table->date('data_emissao');
            $table->string('cnpj_remetente');
            $table->string('nome_remetente');
            $table->string('cnpj_transportador');
            $table->string('nome_transportador');

            $table->foreign("id_usuario")->references("id")->on("usuarios");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notafiscal');
    }
};
