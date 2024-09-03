<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandsTable extends Migration
{
    public function up()
    {
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->string('location');
            $table->decimal('price', 10, 2);
            $table->decimal('area', 8, 2); // Surface du terrain
            $table->foreignId('seller_id')->constrained('users'); // Clé étrangère vers 'users'
            $table->boolean('is_sold')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lands');
    }
}
