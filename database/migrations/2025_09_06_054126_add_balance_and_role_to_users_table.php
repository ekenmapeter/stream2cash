<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

  public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->decimal('balance', 10, 2)->default(0.00);
        $table->enum('role', ['user', 'admin'])->default('user');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['balance', 'role']);
    });
}

};
