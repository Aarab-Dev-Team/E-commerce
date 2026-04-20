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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')  ; 
            $table->foreign('user_id') 
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade') ; 
                
            $table->string('order_number')->unique() ; 
            $table->decimal('total_amount' , 10 , 2 )  ;

            $table->enum('status' , ['pending' ,'processing' ,"shipped", "delivered" , "cancelled"])->default('pending') ; 
            $table->text('shipping_address') ; 
            $table->text('billing_address')->nullable() ; 
            $table->string('payment_method') ; 
            $table->enum('payment_status' , ['pending' , "paid" ,"failed"])->default('pending') ; 
            $table->text('notes')->nullable() ; 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
