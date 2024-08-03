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
            $table->string('itemId')->nullable();
            $table->string('title', 800)->nullable();
            $table->date('createDate')->nullable()->date_format('Y-m-d');
            $table->string('userKey')->nullable();
            $table->string('userId')->nullable();
            $table->string('userPhone')->nullable();
            $table->string('userName')->nullable();
            $table->string('userEmail')->nullable();
            $table->boolean('processed')->default(false);
            $table->date('processDate')->nullable()->date_format('Y-m-d');
            $table->boolean('contact')->default(false);
            $table->date('contactDate')->nullable()->date_format('Y-m-d');
            $table->boolean('complete')->default(false);
            $table->date('completeDate')->nullable()->date_format('Y-m-d');
            $table->boolean('discard')->default(false);
            $table->date('discardDate')->nullable()->date_format('Y-m-d');
            $table->integer('location')->nullable();
            $table->string('transitLocation')->nullable();
            $table->date('transitDate')->nullable()->date_format('Y-m-d');
            $table->text('comments')->nullable();
            $table->boolean('notified')->default(false);
            $table->date('noticeDate')->nullable()->date_format('Y-m-d');
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
