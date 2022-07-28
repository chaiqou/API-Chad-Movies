<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Comment;
use App\Events\CommentEvent;
use App\Events\NotificationEvent;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Notifications\NewCommentNotification;

class CommentController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Quote $quote)
	{
		return CommentResource::collection($quote->comments);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Quote $quote, Request $request)
	{
		$comment = $quote->comment()->create($request->all());

		$user = $quote->user;

		if ($comment->user_id !== $quote->user_id)
		{
			$user->notify(new NewCommentNotification($comment));
		}

		broadcast(new CommentEvent($comment))->toOthers();
		broadcast(new NotificationEvent($comment))->toOthers();

		return response()->json(['comment' => $comment], 201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\Comment $comment
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Quote $quote, Comment $comment)
	{
		return new CommentResource($comment);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Comment      $comment
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Comment $comment)
	{
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\Comment $comment
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Quote $quote, Comment $comment)
	{
		$comment->delete();
		return response(null, 204);
	}
}
