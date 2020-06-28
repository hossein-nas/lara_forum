<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Exception;
use App\Inspections\Spam;
use Illuminate\Http\Request;

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

	public function store($channelId, Thread $thread, Spam $spam)
	{

		try{
			$this->validateReply();

			$reply = $thread->addReply([
				'user_id'		=> auth()->id(),
				'body' 			=> request('body')
			]);
		}catch(Exception $e){
			return response('Sorry, your reply could not be saved at this time.', 422);	
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
			$this->validateReply();

			$reply->update(request(['body']));
		}catch(Exception $e){
			return response(
				'Sorry, your reply could not be saved at this time.',
				 422
			);	
		}
	}

	public function validateReply()
	{
			$this->validate(request(), [
				'body'			=> 'required',
			]);

			resolve(Spam::class)->detect(request('body'));
	}
}
