<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles_commande', function (Blueprint $table) {
            $table->dateTime('date_debut')->nullable()->after('prix_total');
            $table->dateTime('date_fin')->nullable()->after('date_debut');
        });
    }

    public function down(): void
    {
        Schema::table('articles_commande', function (Blueprint $table) {
            $table->dropColumn(['date_debut', 'date_fin']);
        });
    }
};
