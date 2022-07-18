<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Http\Request;

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
		$comment = $quote->comments()->create($request->all());
		return response()->json(['comment' => new CommentResource($comment)], 201);
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
