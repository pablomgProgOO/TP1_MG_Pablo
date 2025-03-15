<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->date('birthdate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actors');
    }
};
