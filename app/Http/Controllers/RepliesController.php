<?php

namespace App\Http\Controllers;

use App\User;
use App\Reply;
use Exception;
use App\Thread;
use Illuminate\Support\Facades\Gate;
use App\Notifications\YouWereMentioned;
use App\Http\Requests\CreatePostRequest;

class RepliesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth', ['except' => 'index']);	
	}

	public function index($channelId, Thread $thread)
	{
		return $thread->replies()->paginate(5);			
	}

	public function store($channelId, Thread $thread, CreatePostRequest $form)
	{
		return $thread->addReply([
			'user_id'		=> auth()->id(),
			'body' 			=> request('body')
		])->load('owner');
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
		
		$this->validate(request(), ['body' => 'required|spamfree']);

		$reply->update(request(['body']));
	}
}
