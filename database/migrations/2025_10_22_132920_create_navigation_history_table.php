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
        Schema::create('navigation_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained()->onDelete('cascade');
            $table->string('page_name', 255);
            $table->string('page_url', 500);
            $table->timestamp('visited_at');
            $table->integer('time_spent')->default(0); // en secondes
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('session_id', 100)->nullable();
            $table->timestamps();

            // Index pour les performances et les requêtes
            $table->index(['admin_id', 'visited_at']);
            $table->index('visited_at');
            $table->index('page_name');
            $table->index(['visited_at', 'admin_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigation_history');
    }
};