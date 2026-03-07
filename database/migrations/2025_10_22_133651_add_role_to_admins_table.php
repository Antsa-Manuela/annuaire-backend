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
        // Ajouter 'role' si elle n'existe pas
        if (!Schema::hasColumn('admins', 'role')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->enum('role', ['super_admin', 'admin'])
                      ->default('admin')
                      ->after('password');
            });
        }

        // Ajouter 'last_login_at' si elle n'existe pas
        if (!Schema::hasColumn('admins', 'last_login_at')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->timestamp('last_login_at')
                      ->nullable()
                      ->after('role');
            });
        }

        // Ajouter 'is_active' si elle n'existe pas
        if (!Schema::hasColumn('admins', 'is_active')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->boolean('is_active')
                      ->default(true)
                      ->after('last_login_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer 'is_active' si elle existe
        if (Schema::hasColumn('admins', 'is_active')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }

        // Supprimer 'last_login_at' si elle existe
        if (Schema::hasColumn('admins', 'last_login_at')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('last_login_at');
            });
        }

        // Supprimer 'role' si elle existe
        if (Schema::hasColumn('admins', 'role')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};