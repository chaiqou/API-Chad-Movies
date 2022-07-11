<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
	use HasFactory;

	use HasTranslations;

	public $translatable = ['title', 'description', 'director'];

	protected $fillable = [
		'title',
		'director',
		'genre',
		'description',
		'year',
		'budget',
		'user_id',
	];

	public function quotes()
	{
		return $this->hasMany(Quote::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
