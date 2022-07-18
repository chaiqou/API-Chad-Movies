<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
	use HasFactory;

	use HasTranslations;

	public $translatable = ['quote'];

	protected $fillable = [
		'quote',
		'thumbnail',
		'movie_id',
	];

	public function movie()
	{
		return $this->belongsTo(Movie::class, 'movie_id');
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function likes()
	{
		return $this->hasMany(Like::class);
	}
}
