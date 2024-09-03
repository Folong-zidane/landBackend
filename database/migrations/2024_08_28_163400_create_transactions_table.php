<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('land_id')->constrained('lands'); // Clé étrangère vers 'lands'
            //$table->foreignId('buyer_id')->constrained('users'); // Clé étrangère vers 'users'
            //$table->foreignId('seller_id')->constrained('users'); // Clé étrangère vers 'users'
            $table->decimal('price', 10, 2);
            $table->boolean('status')->default(false);
            $table->timestamp('transaction_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
