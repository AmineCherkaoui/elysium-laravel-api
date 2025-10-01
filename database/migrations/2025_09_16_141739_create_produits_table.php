<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom');
            $table->string('slug')->unique();
            $table->string('fabricant');
            $table->text('description');
            $table->string('imageUrl')->nullable();
            $table->integer('resolutionX')->nullable();
            $table->integer('resolutionY')->nullable();
            $table->float('taillePouces')->nullable();
            $table->integer('luminositeNits')->nullable();
            $table->integer('tauxRafraichissementHz')->nullable();
            $table->float('puissanceWatts')->nullable();
            $table->float('prixLocation')->nullable();
            $table->float('prixVente')->nullable();
            $table->string('category');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};

