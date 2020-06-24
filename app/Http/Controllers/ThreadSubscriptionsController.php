<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('auth');    
    }
    

    /*
     * Function for :: store ::
     *
     */
    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();
    }

    /*
     * Function for :: destroy ::
     *
     */
    public function destroy($channelId, Thread $thread)
    {
        $thread->unsubscribe();    
    }
    
    
}
