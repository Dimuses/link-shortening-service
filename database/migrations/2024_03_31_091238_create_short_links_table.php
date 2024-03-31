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
        Schema::create('short_links', function (Blueprint $table) {
            $table->id();
            $table->string('original_link');
            $table->string('short_link', 8)->unique();
            $table->integer('max_visits')->default(0);
            $table->integer('visits')->default(0)->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
