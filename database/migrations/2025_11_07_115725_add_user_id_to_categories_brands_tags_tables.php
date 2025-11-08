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
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });
    }



    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
