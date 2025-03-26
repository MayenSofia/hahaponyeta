<?php
// database/migrations/xxxx_create_checkouts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration {
    public function up() {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->timestamp('checked_out_at')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('checkouts');
    }
}
