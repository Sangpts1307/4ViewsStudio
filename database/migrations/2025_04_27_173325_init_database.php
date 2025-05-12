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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->integer('role')->default(2);
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->string('account_number')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('concepts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->string('short_content');
            $table->string('content');
            $table->timestamps();
        });
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->integer('role')->default(0);
            $table->foreignId('concept_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
       

       
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->timestamp('expense_day');
            $table->timestamps();
        });
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('base_salary');
            $table->integer('total_shift')->default(0);
            $table->integer('finished_shift')->default(0);
            $table->string('total_salary')->nullable();
            $table->string('month');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->time('start_time');
            $table->time('end_time');
           
            $table->timestamps();
        });
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shift_id')->constrained()->onDelete('cascade');
            
            $table->timestamp('work_day');
            $table->timestamps();
        });
        
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('users')->onDelete('cascade')->nullable();
            $table->foreignId('concept_id')->constrained()->onDelete('cascade');
            $table->foreignId('shift_id')->constrained()->onDelete('cascade'); 
            $table->timestamp('work_day');
            $table->string('note')->nullable();
            $table->string('reply')->nullable();
            $table->string('link_image')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->integer('role')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
