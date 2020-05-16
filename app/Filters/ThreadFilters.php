<?php

namespace App\Filters;

class ThreadFilters extends Filters
{

	protected $filters = ['by', 'popular'];
	
	protected function by($username)
	{
		$user = \App\User::where('name' , $username)->first();

		return $this->builder->where('user_id', $user->id);
	}

	protected function popular()
	{
		$this->builder->getQuery()->orders = [];
		return $this->builder->orderBy('replies_count', 'desc');	
	}
	

}