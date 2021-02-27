<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name', 100)->nullable(false);
            $table->text('content')->nullable(false);
            $table->string('slug', 100)->unique()->nullable(false);
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы pages
            $table->foreign('parent_id')
                ->references('id')
                ->on('pages')
                ->nullOnDelete();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('pages');
    }
}
