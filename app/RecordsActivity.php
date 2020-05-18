<?php

namespace App;

use App\Activity;

trait RecordsActivity 
{

	public static function bootRecordsActivity()
	{
        if( !auth()->check() ) return;
        
        foreach( static::getActivitiesToRecord() as $event ) {
            static::$event( function($model) use ($event){
                $model->recordActivity($event);
            });
        }
	}

    public static function  getActivitiesToRecord()
    {
        return ['created'];    
    }
    

    protected function recordActivity($event)
    {
    	$this->activity()->create([
			'user_id'       => auth()->id(),
			'type'          => $this->getActivityType($event)
    	]);
    }

    public function activity()
    {
    	return $this->morphMany(Activity::class, 'subject');	
    }
    

    /**
     * This method generates activity type like 'created_thread',
     * 
     * @param  $even
     * @return string
     */
    protected function getActivityType($event)
    {
    	$type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
} 