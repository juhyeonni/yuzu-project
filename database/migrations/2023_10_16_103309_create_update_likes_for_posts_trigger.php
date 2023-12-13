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
    DB::unprepared('
        CREATE TRIGGER update_like_for_posts_after_insert AFTER INSERT ON likes
        FOR EACH ROW
        BEGIN
          UPDATE posts
          SET `like` = (
            SELECT COUNT(*) FROM likes WHERE post_id = NEW.post_id
          )
          WHERE id = NEW.post_id;
        END
      ');
    DB::unprepared('
        CREATE TRIGGER update_like_for_posts_after_delete AFTER DELETE ON likes
        FOR EACH ROW
        BEGIN
          UPDATE posts
          SET `like` = (
            SELECT COUNT(*) FROM likes WHERE post_id = OLD.post_id
          )
          WHERE id = OLD.post_id;
        END
      ');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::unprepared(
      "DROP TRIGGER IF EXISTS update_likes_for_posts_after_insert"
    );
    DB::unprepared(
      "DROP TRIGGER IF EXISTS update_likes_for_posts_after_delete"
    );
  }
};
