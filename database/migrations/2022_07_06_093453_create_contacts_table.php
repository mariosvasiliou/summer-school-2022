<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('legal_name')->nullable();
            $table->boolean('is_legal_entity');
            $table->string('gender', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('street')->nullable();
            $table->string('building')->nullable();
            $table->string('number', 10)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('home_number', 30)->nullable();
            $table->string('mobile_number', 30)->nullable();
            $table->string('work_number', 30)->nullable();
            $table->text('comments')->nullable();
            $table->boolean('is_client');
            $table->boolean('is_user');
            $table->foreignId('department_id')
                  ->nullable()
                  ->constrained('departments')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
