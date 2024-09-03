<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminActionsTable extends Migration
{
    public function up()
    {
        Schema::create('admin_actions', function (Blueprint $table) {
           $table->id();
             $table->foreignId('admin_id')->constrained('users'); // Clé étrangère vers 'users'
            $table->string('action');
            $table->text('description')->nullable();
            $table->timestamp('action_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_actions');
    }
}
