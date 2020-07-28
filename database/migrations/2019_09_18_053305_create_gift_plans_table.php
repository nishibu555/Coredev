<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->string('relation')->nullable();
            $table->string('occasion')->nullable();
            $table->date('occasion_date')->nullable();
            $table->decimal('budget')->nullable();
            $table->unsignedInteger('share_budget')->nullable();
            $table->string('idea_level')->nullable();
            $table->string('claiming_token')->nullable();

            $table->enum('currency', config('enums.currencies'))->default(config('enums.currencies')[0]);

            $table->enum('status', array_keys(config('enums.gift_plans_statuses')))
                ->default(array_keys(config('enums.gift_plans_statuses'))[0]);

            $table->unsignedInteger('is_anonymous')->default(false);
            $table->unsignedBigInteger('delivery_address_id')->nullable();
            //Giftee
            $table->string('receiver_relation_with_giftee')->nullable();
            $table->string('giftee_name')->nullable();
            $table->enum('giftee_gender', config('enums.genders'))->nullable();
            $table->integer('giftee_age')->nullable();
            $table->string('giftee_age_range')->nullable();
            $table->boolean('is_required_delivery_address')->default(0)->nullable();
            $table->dateTime('viewed_at')->nullable();
            $table->dateTime('ignored_at')->nullable();

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
        Schema::dropIfExists('gift_plans');
    }
}
