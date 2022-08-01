<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Comment;
use App\Events\CommentEvent;
use App\Events\NotificationEvent;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
	public function index(Quote $quote): AnonymousResourceCollection
	{
		return CommentResource::collection($quote->comment);
	}

	public function store(Quote $quote, Request $request): JsonResponse
	{
		$comment = $quote->comment()->create($request->all());

		broadcast(new CommentEvent($comment));

		broadcast(new NotificationEvent($comment, $quote))->toOthers();

		return response()->json(['comment' => $comment], 201);
	}

	public function show(Quote $quote, Comment $comment): CommentResource
	{
		return new CommentResource($comment);
	}

	public function destroy(Quote $quote, Comment $comment)
	{
		$comment->delete();
		return response(null, 204);
	}
}
