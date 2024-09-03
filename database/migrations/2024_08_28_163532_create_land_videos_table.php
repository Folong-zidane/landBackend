<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandVideosTable extends Migration
{
    public function up()
    {
        Schema::create('land_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('land_id')->constrained('lands'); // Clé étrangère vers 'lands'
            $table->string('url'); // Stockage des URL des images/vidéos
            $table->string('caption')->nullable(); // Description ou légende de l'image/vidéo
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('land_videos');
    }
}
