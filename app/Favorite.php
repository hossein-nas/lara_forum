<?php

namespace App;

use App\User;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
	use RecordsActivity;

	protected $with = ['user'];
	
	protected $guarded = [];

	public function user()
	{
		return $this->belongsTo(User::class);	
	}

	public function favorited()
	{
		return $this->morphTo();	
	}
	
}
