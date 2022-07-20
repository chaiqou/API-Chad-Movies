<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
			'commentBy'  => $this->data['commentBy'],
			'comment'    => $this->data['comment'],
			'created_at' => $this->data['created_at'],
			'id'         => $this->id,
		];
	}
}
