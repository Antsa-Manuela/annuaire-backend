<?php
// database/migrations/2024_01_01_000000_create_etablissements_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('etablissements', function (Blueprint $table) {
            $table->string('CODE_ETAB', 20)->primary();
            $table->tinyInteger('SECTEUR');
            $table->string('CISCO', 50);
            $table->string('COMMUNE', 100);
            $table->string('ZAP', 100)->nullable();
            $table->string('FOKONTANY', 100)->nullable();
            $table->string('NOM_ETAB', 200);
            $table->decimal('X', 12, 8)->nullable();
            $table->decimal('Y', 12, 8)->nullable();
            $table->integer('nb_ENF')->default(0);
            $table->integer('nb_Ens_foncts')->default(0);
            $table->integer('nb_PA_NonFonct')->default(0);
            $table->integer('nb_PA_Fonct')->default(0);
            $table->integer('nb_Benevoles')->default(0);
            $table->integer('effectif_total_Personnel')->default(0);
            
            $table->timestamps();
            
            // Index pour les recherches
            $table->index('SECTEUR');
            $table->index('CISCO');
            $table->index('COMMUNE');
            $table->index(['X', 'Y']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('etablissements');
    }
};