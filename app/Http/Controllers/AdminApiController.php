<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminApiController extends Controller
{
	public function createPost(Request $request)
	{
		$request->validate([
			'title' => 'required|max:255',
			'content' => 'required',
		]);
		$post = new \App\Post;
		$post->title = $request['title'];
		$post->content = $request['content'];
		$post->save();
		return response($post, 201); // Status code here
	}

	public function updatePost(Request $request, $ID)
	{
		$request->validate([
			'title' => 'required|max:255',
			'content' => 'required',
		]);
		$post = \App\Post::findOrFail($ID);
		$post->title = $request['title'];
		$post->content = $request['content'];
		$post->save();
		return response($post, 200); // Status code here
	}

	public function deletePost(Request $request, $ID)
	{
		$post = \App\Post::findOrFail($ID);
		$post->delete();
		return response("Deleted", 200);
	}

	public function getALlPosts()
	{
		return \App\Post::all();
	}
}