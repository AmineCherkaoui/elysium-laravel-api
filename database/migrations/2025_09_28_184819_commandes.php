<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('numero_commande')->unique();
            $table->string('nom_client');
            $table->string('email_client');
            $table->string('telephone_client');
            $table->text('adresse_client');
            $table->enum('status', ['en_attente', 'confirmee', 'en_traitement', 'livree', 'annulee'])->default('en_attente');
            $table->decimal('montant_total', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
