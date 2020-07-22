<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Trending;
use Illuminate\Http\Request;

class SearchThreadsController extends Controller
{

    public function index(Request $request, Trending $trending)
    {
        $search = $request->get('q');

        $threads = Thread::search($search)->paginate(20);

        if ($request->expectsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads'  => $threads,
            'trending' => $trending->get(),
        ]);
    }
}
