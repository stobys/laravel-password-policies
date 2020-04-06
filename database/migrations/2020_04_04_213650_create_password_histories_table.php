<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordHistoriesTable extends Migration
{
    // -- Run the migrations
    public function up()
    {
        $passwordHistoryTableName = config('password-polices.password_history_table', 'password_histories');

        Schema::create($passwordHistoryTableName, function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> binInteger('user_id');
            $table -> string('password');
			$table -> dateTime('created_by') -> nullable();
            $table -> dateTime('created_at');
            $table -> dateTime('updated_at') -> nullable() -> useCurrent();
        });
    }

    // -- Reverse the migrations
    public function down()
    {
        $passwordHistoryTableName = config('password-polices.password_history_table', 'password_histories');

        Schema::dropIfExists($passwordHistoryTableName);
    }
}
