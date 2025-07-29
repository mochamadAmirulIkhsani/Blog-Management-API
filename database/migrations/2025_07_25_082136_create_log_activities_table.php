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
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('action', 30)->varchar();
            $table->string('entity');
            $table->unsignedBigInteger('entity_id');
            $table->json('details')->nullable();
            $table->enum('status', ['success', 'failure']);
            $table->text('error_message')->nullable();
            $table->string('ip_address', 32)->varchar()->nullable();
            $table->string('user_agent', 100)->varchar();
            $table->string('request_method')->nullable();
            $table->text('url_accessed')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_activities');
    }
};
