<?php

namespace App;

trait Favoritable
{

    public static function bootFavoritable()
    {
        static::deleting(function($model){
            $model->favorites->each->delete();
        });
    }

    public function favorites()
    {
    	return $this->morphMany(Favorite::class, 'favorited');	
    }

    public function favorite()
    {
    	if( $this->favorites()->where('user_id', auth()->id())->exists() ) return;

    	$this->favorites()->create([
    		'user_id' => auth()->id()
    	]);
    }

    public function unfavorite()
    {
        $favorites= $this->favorites()->where('user_id', auth()->id())->get();
        if( $favorites->count() ) {
            $favorites->each->delete();
        }
    }
    
    public function isFavorited()
    {
    	return  !! $this->favorites->where('user_id', auth()->id() )->count();
    }

    /*
     * Function for :: getfavoritedByMeAttribute ::
     *
     */
    public function getfavoritedByMeAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
    	return $this->favorites->count();	
    }

}