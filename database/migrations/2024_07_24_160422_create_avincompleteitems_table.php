<?php

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
        Schema::create('avincompleteitems', function (Blueprint $table) {
            $table->id();
            $table->string('itemId');
            $table->string('title', 800)->nullable();
            $table->dateTime('createDate')->nullable();
            $table->string('userKey')->nullable();
            $table->string('userId')->nullable();
            $table->string('userPhone')->nullable();
            $table->string('userName')->nullable();
            $table->string('userEmail')->nullable();
            $table->boolean('processed')->default(false);
            $table->dateTime('processDate')->nullable();
            $table->string('contact')->nullable();
            $table->dateTime('contactDate')->nullable();
            $table->boolean('complete')->default(false);
            $table->dateTime('completeDate')->nullable();
            $table->boolean('discard')->default(false);
            $table->dateTime('discardDate')->nullable();
            $table->integer('location');
            $table->string('transitLocation')->nullable();
            $table->dateTime('transitDate')->nullable();
            $table->text('comments')->nullable();
            $table->boolean('notified')->default(false);
            $table->dateTime('noticeDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avincompleteitems');
    }
};
