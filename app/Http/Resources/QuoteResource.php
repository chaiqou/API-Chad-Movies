<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request)
	{
		return [
			'id'             => $this->id,
			'quote'          => $this->getTranslations(),
			'thumbnail'      => $this->thumbnail,
			'movie_id'       => $this->movie_id,
			'user_id'        => $this->user_id,
			'comments'       => CommentResource::collection($this->comment),
			'comments_count' => $this->comment->count(),
			'likes'          => LikeResource::collection($this->like),
			'likes_count'    => $this->like->count(),
			'userinfo'       => new UserResource($this->user),
			'movieinfo'      => new MovieResource($this->movie),
		];
	}
}
