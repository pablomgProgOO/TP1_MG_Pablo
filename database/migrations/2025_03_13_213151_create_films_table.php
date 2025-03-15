<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up():void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id(); 
            $table->string('title', 50);
            $table->string('release_year', 4);
            $table->integer('length');  
            $table->text('description');
            $table->string('rating', 10);
            $table->unsignedBigInteger('language_id');  
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade'); // Ensures referential integrity
            $table->string('special_features', 200);
            $table->string('image', 40)->nullable();
            $table->date('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
