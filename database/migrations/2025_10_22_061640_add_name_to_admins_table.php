<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Ajouter 'role' si elle n'existe pas
        if (!Schema::hasColumn('admins', 'role')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('role')
                    ->default('admin')
                    ->check("role in ('super_admin', 'admin')")
                    ->after('name');
            });
        }

        // Ajouter 'last_login_at' si elle n'existe pas
        if (!Schema::hasColumn('admins', 'last_login_at')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->timestamp('last_login_at')->nullable()->after('role');
            });
        }

        // Ajouter 'is_active' si elle n'existe pas
        if (!Schema::hasColumn('admins', 'is_active')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('last_login_at');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('admins', 'role')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }

        if (Schema::hasColumn('admins', 'last_login_at')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('last_login_at');
            });
        }

        if (Schema::hasColumn('admins', 'is_active')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};