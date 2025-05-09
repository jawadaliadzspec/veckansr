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
        Schema::table('stores', function (Blueprint $table) {
            $table->unsignedBigInteger('channelId')->nullable();
            $table->string('channelName')->nullable();
            $table->unsignedBigInteger('programId')->nullable()->unique();
            $table->string('categoryName')->nullable();
            $table->unsignedBigInteger('categoryId')->nullable();
            $table->unsignedBigInteger('productFeedId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn([
                'channelId',
                'channelName',
                'programId',
                'categoryName',
                'categoryId',
            ]);
        });
    }
};
