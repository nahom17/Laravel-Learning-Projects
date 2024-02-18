<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleStoreValidation;
use App\Http\Requests\ArticletUpdateValidation;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    public function index()
    {

        $articles = Article::orderBydesc('id')->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function articleIndex()
    {
        $today = now();
        $articles = Article::where([['start_date', '<=', $today], ['end_date', '>', $today]])->orderBy('end_date', 'asc')->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function myArticles(Request $request)
    {
        $articles = Article::where('user_id', $request->user()->id)->paginate(30);

        return view('articles.myarticles', compact('articles'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $articles = Article::query()
            ->where('title', 'LIKE', '%'.$search.'%')
            ->paginate(30);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $this->authorize('isAdmin', User::class);

        return view('admin.articles.create');
    }

    public function store(ArticleStoreValidation $request, User $user)
    {
        $article = new Article;
        $article->user_id = $request->user()->id;
        $article->title = $request->title;
        $article->intro = $request->intro;
        $article->description = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move('uploads/article/', $filename);
            $article->image = $filename;
        }

        $article->start_date = $request->start_date;
        $article->end_date = $request->end_date;
        $article->save();

        return redirect()->route('admin.articles.index')->with('message', 'Artikel toegevoged');

    }

    public function show(Article $article)
    {

        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $this->authorize('isAdmin', User::class);

        return view('admin.articles.edit', compact('article'));
    }

    public function update(ArticletUpdateValidation $request, Article $article)
    {
        $article->title = $request->title;
        $article->intro = $request->intro;
        $article->description = $request->description;

        if ($request->hasFile('image')) {
            $destination = 'uploads/article/'.$article->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move('uploads/article/', $filename);
            $article->image = $filename;
        }

        $article->start_date = $request->start_date;
        $article->end_date = $request->end_date;

        $article->update();

        return redirect()->route('admin.articles.index')->with('message', 'Artikel bijgewerkt');
    }

    public function destroy(Article $article)
    {
        if ($article) {
            $destination = 'uploads/article/'.$article->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $article->delete();

            return redirect()->route('admin.articles.index')->with('message', 'Artikel verwijdered');

        } else {
            return redirect()->route('admin.articles.index')->with('message', 'Geen article gevonden');
        }
    }
}
