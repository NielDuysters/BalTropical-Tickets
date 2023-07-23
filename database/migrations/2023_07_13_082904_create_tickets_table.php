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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string("firstname");
            $table->string("lastname");
            $table->string("email");
            $table->date("birthdate");
            $table->tinyInteger("accepted_agreements")->default(0);
            $table->string("payment_id")->nullable();
            $table->string("payment_status");
            $table->tinyInteger("paid")->nullable();
            $table->string("code")->unique();
            $table->tinyInteger("from_current_user");
            $table->tinyInteger("used")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
