<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create("game_scores", function (Blueprint $table) {
      $table
        ->foreignId("user_id")
        ->constrained("users")
        ->cascadeOnDelete()
        ->cascadeOnUpdate();
      $table->unsignedBigInteger("score")->default(0);
      $table->timestamps();

      $table->primary("user_id");
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists("game_scores");
  }
};
