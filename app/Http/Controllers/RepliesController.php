<?php

namespace App\Http\Controllers;

use App\Reply;
use Exception;
use App\Thread;

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

	public function store($channelId, Thread $thread)
	{
		try{
			$this->authorize('create', new Reply);
			$this->validate(request(), ['body' => 'required|spamfree']);

			$reply = $thread->addReply([
				'user_id'		=> auth()->id(),
				'body' 			=> request('body')
			]);
		}catch(Exception $e){
			return response(
				'Sorry, your reply could not be saved at this time.',
				 422
			);	
		}

		return $reply->load('owner');
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
		
		try{
			$this->validate(request(), ['body' => 'required|spamfree']);

			$reply->update(request(['body']));
		}catch(Exception $e){
			return response(
				'Sorry, your reply could not be saved at this time.',
				 422
			);	
		}
	}
}
