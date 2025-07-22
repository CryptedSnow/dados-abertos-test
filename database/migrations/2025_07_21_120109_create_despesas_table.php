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
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deputado_id')->constrained('deputados');
            $table->string('tipo_despesa')->nullable();
            $table->decimal('valor', 10, 2)->default(0);
            $table->string('fornecedor')->nullable();
            $table->string('url_documento')->nullable();
            $table->date('data_documento')->nullable();
            $table->timestamps();

            $table->index(['deputado_id', 'data_documento', 'valor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};
