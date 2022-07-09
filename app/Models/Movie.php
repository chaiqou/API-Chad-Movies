<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
	use HasFactory;

	protected $guarded = [];

	public function quotes()
	{
		return $this->hasMany(Quote::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
