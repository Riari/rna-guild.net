<?php namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display an article.
     *
     * @param  Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('article.show', compact('article') + [
            'commentPaginator' => $article->comments()->orderBy('created_at', 'desc')->paginate()
        ]);
    }
}
