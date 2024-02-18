<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = now();
        $articles = Article::where([['start_date', '<=', $today], ['end_date', '>', $today]])->orderby('end_date', 'asc')->paginate(3);

        return view('articles.index', compact('articles'));
    }
}
