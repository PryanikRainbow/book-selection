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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('edition')->nullable();
            $table->foreignId('publisher_id')->constrained();
            $table->date('release_date');
            $table->foreignId('format_id')->constrained();
            $table->integer('pages');
            $table->foreignId('country_id')->constrained();
            $table->string('ISBN',13);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['publisher_id']);
            $table->dropForeign(['format_id']);
            $table->dropForeign(['country_id']);
        });
        
        Schema::dropIfExists('books');
    }
};
