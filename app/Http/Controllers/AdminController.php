<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.index')->with('posts', \App\Post::all());
    }

	/**
	 * View/Edit a Post.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function editPost(Request $request, $ID = null) {
//	    return view('backend.index')->with('posts', []);
		return view('backend.editPost')->with(
			'post', $ID ? \App\Post::findOrFail($ID) : null
		);
    }

}