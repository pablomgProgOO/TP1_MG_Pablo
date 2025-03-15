<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('actor_film', function (Blueprint $table) {
            $table->unsignedBigInteger('actor_id');
            $table->unsignedBigInteger('film_id');
            $table->date('created_at');
            $table->date('updated_at')->nullable();
            $table->foreign('actor_id')->references('id')->on('actors')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->primary(['actor_id', 'film_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actor_film');
    }
};
