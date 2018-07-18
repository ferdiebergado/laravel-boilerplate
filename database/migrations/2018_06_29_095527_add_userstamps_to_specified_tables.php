<?php

use Illuminate\Database\Migrations\Migration;
use App\Userstamps;

class AddUserstampsToSpecifiedTables extends Migration
{
    protected $tabs = [
        'roles',
        'permissions'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Userstamps::create($this->tabs);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Userstamps::drop($this->tabs);
    }
}
