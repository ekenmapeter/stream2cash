<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('withdrawals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->string('method'); // PayPal, Bank, Crypto
        $table->text('account_details');
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->timestamp('requested_at')->useCurrent();
        $table->timestamp('processed_at')->nullable();
    });
}

public function down()
{
    Schema::dropIfExists('withdrawals');
}

};
