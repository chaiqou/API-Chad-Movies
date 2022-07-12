<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
	use HasFactory;

	protected $guarderd = [];

	public function movie()
	{
		return $this->belongsTo(Movie::class);
	}
}
