<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
	use HasFactory;

	protected $fillable = ['text', 'user_id'];

	public function movie()
	{
		return $this->belongsTo(Movie::class);
	}
}
