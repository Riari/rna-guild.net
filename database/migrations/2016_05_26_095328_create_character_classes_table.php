<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_classes', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        DB::table('character_classes')->insert([
            ['name' => 'Warrior'],
            ['name' => 'Ranger'],
            ['name' => 'Sorceress'],
            ['name' => 'Berserker'],
            ['name' => 'Valkyrie'],
            ['name' => 'Wizard'],
            ['name' => 'Witch'],
            ['name' => 'Tamer'],
            ['name' => 'Maehwa'],
            ['name' => 'Musa']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('character_classes');
    }
}
