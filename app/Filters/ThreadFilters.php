<?php

namespace App\Filters;

class ThreadFilters extends Filters
{

	protected $filters = ['by'];
	
	protected function by($username)
	{
		$user = \App\User::where('name' , $username)->first();

		return $this->builder->where('user_id', $user->id);
	}

}