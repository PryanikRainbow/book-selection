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
        Schema::create('public_books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('edition');
            $table->foreignId('publisher_id')->constrained('publishers');
            $table->year('year');
            $table->foreignId('format_id')->constrained('formats');
            $table->integer('pages');
            $table->foreignId('country_id')->constrained('countries');
            $table->string('ISBN',13);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fublic_books');
    }
};
