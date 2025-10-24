<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        exit;
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('img')->nullable();
            $table->string('designation');
            $table->enum('role', ['developer', 'editor','contributor','subscriber']);
            $table->enum('type', ['all','online','print']);
            $table->integer('status');
            $table->integer('create_by');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->truncate();
        $users = array(
            array(  
                'name' => 'Developer',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'img' => '',
                'designation' => 'Developer',
                'role' => 'developer',
                'type' => 'all',
                'status' => '1',
                'create_by' => '1',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
            )
        );
         DB::table('users')->insert($users);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
