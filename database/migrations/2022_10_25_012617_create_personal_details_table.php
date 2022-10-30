<?php

use App\Models\Country;
use App\Models\Resume;
use App\Models\State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Resume::class);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_no', 20);
            $table->date('birth_date');
            $table->tinyInteger('gender');
            $table->string('address1');
            $table->string('address2');
            $table->string('postal_code');
            $table->string('city');
            $table->foreignIdFor(State::class);
            $table->foreignIdFor(Country::class);
            $table->string('profile_image')->nullable();
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
        Schema::dropIfExists('personal_details');
    }
};
