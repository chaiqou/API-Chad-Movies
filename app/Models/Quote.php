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
		'user_id',
	];

	protected $with = ['user', 'movie', 'comment', 'like'];

	public function movie()
	{
		return $this->belongsTo(Movie::class, 'movie_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function comment()
	{
		return $this->hasMany(Comment::class)->latest();
	}

	public function like()
	{
		// return $this->hasMany(Like::class);
		return $this->belongsToMany(User::class, 'likes', 'quote_id', 'user_id');
	}
}
