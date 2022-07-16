<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
	use HasFactory, HasSlug;

	use HasTranslations;

	public $translatable = ['title', 'description', 'director'];

	protected $fillable = [
		'title',
		'description',
		'director',
		'genre',
		'thumbnail',
		'year',
		'budget',
		'user_id',
	];

	public function getSlugOptions(): SlugOptions
	{
		return SlugOptions::create()
			->generateSlugsFrom('title')
			->saveSlugsTo('slug');
	}

	public function quotes()
	{
		return $this->hasMany(Quote::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
