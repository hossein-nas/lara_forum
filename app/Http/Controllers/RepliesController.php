<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');	
	}
	

	public function store($channelId, Thread $thread)
	{
		$this->validate(request(), [
			'body'			=> 'required',
		]);

		$reply = $thread->addReply([
			'user_id'		=> auth()->id(),
			'body' 			=> request('body')
		]);

		if( request()->expectsJson()){
			return $reply->load('owner');
		}

		return back()->with('flash', 'Your reply has been left.');
	}

	
	public function destory(Reply $reply)
	{
		$this->authorize('update', $reply);

		$reply->delete();

		if( request()->expectsJson()){
			return response(['status' => 'Your reply deleted.']);
		}

		return back();
	}

	public function update(Reply $reply)
	{
		$this->authorize('update', $reply);
		
		$reply->update(request(['body']));
	}
	

}
