<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('buyer');
            $table->string('boutique_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('address')->nullable();
            $table->string('city')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'boutique_name',
                'phone',
                'whatsapp',
                'is_active',
                'address',
                'city'
            ]);
        });
    }
};