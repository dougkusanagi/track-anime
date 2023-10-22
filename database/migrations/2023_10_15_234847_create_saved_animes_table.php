<?php

use App\Enums\SavedAnimeScoreEnum;
use App\Enums\SavedAnimeStatusEnum;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saved_animes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();

            $table->bigInteger('mal_id');
            $table->string('title');
            $table->string('notes')->nullable();
            $table->enum('status', SavedAnimeStatusEnum::names())->default(SavedAnimeStatusEnum::Watching->name);
            $table->enum('score', SavedAnimeScoreEnum::names())->default(SavedAnimeScoreEnum::Zero->name);
            $table->integer('rewatch_count')->default(0);
            $table->integer('episode_count')->default(0);
            $table->boolean('favorite')->default(false);
            $table->text('link')->nullable();

            $table->text('image_cover_url');
            $table->text('image_banner_url')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_animes');
    }
};
