<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialDbStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_sets', function(Blueprint $table) {
        
            $table->increments('id')->unsigned();
            $table->string('name', 191);
            $table->string('type', 191)->nullable()->default(null);
            $table->string('school_year', 191)->nullable()->default(null);
            $table->string('associated_id', 191)->nullable()->default(null);
            $table->string('department', 191)->nullable()->default(null);
            $table->string('uploader', 191)->nullable()->default(null);
            $table->integer('folder_id')->nullable()->default(null);
        
            $table->timestamps();
        
        });

        Schema::create('files', function(Blueprint $table) {
        
            $table->increments('id')->unsigned();
            $table->string('file_set_id', 191);
            $table->longText('value');
            $table->string('index', 191);
            $table->integer('width')->nullable()->default(null);
            $table->integer('height')->nullable()->default(null);
        
            $table->timestamps();
        
        });

        Schema::create('folders', function(Blueprint $table) {
        
            $table->increments('id');
            $table->string('name', 45)->nullable()->default(null);
            $table->boolean('archived')->nullable()->default('0');
        
            $table->timestamps();
        
        });

        Schema::create('password_resets', function(Blueprint $table) {
        
            $table->string('email', 191);
            $table->string('token', 191);
        
            $table->index('email','password_resets_email_index');
        
            $table->timestamps();
        
        });

        Schema::create('users', function(Blueprint $table) {
        
            $table->increments('id')->unsigned();
            $table->string('name', 191);
            $table->string('username', 191);
            $table->string('role', 191);
            $table->string('password', 191);
            $table->string('remember_token', 100)->nullable()->default(null);
        
            $table->timestamps();
        
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('password_resets');
        Schema::drop('migrations');
        Schema::drop('folders');
        Schema::drop('files');
        Schema::drop('file_sets');

    }
}

