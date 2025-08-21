<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_link_id')->constrained()->cascadeOnDelete();
            $table->integer('number');
            $table->string('status')->index();
            $table->integer('win_amount');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_records');
    }
};
