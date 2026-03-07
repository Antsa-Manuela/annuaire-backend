<?php
// database/migrations/2025_10_16_042108_add_email_to_admins_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Vérifier si la colonne existe déjà avant de l'ajouter
        if (!Schema::hasColumn('admins', 'email')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('email')->nullable()->after('id');
            });
        }
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};