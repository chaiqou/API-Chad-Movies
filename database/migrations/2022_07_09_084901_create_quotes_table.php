<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotes', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('movie_id')->unsigned();
			$table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
			$table->text('quote');
			$table->text('thumbnail');
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
		Schema::dropIfExists('quotes');
	}
};
