<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_mgmts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('book_id')->constrained();
            $table->integer('a_day');
            $table->foreignId('intarval_id')->constrained();
            $table->integer('today_rest')->default('0');
            $table->integer('next');
            $table->date('next_learn_at')->nullable();
            $table->float('percent', 5, 1)->default('0');
            $table->date('end_date')->nullable();
            $table->foreignId('schedule_id')->constrained()->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_mgmts');
    }
};
