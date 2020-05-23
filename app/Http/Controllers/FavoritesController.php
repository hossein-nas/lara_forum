<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');	
	}
	
	public function store(Reply $reply)
	{
		$reply->favorite();

		if( request()->expectsJson() ){
			return response(['status' => "You've been favorited successfully." ]);
		}
		return back();
	}

	
	public function destroy(Reply $reply)
	{
		$reply->unfavorite();	

		if( request()->expectsJson() ){
			return response(['status' => 'You unfavorited successfully']);
		}

		return back();
	}
	
}
