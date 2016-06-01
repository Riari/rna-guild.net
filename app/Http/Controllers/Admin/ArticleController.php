<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notification;

class ArticleController extends Controller
{
    /**
     * @var array
     */
    protected $rules = [
        'title' => 'required',
        'body' => 'required',
        'published_at' => 'required'
    ];

    /**
     * Display an index of articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.article.index', [
            'paginator' => Article::orderBy('created_at', 'desc')->paginate()
        ]);
    }

    /**
     * Display a create article page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->edit(new Article);
    }

    /**
     * Store an article.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $article = Article::create([
            'user_id' => Auth::user()->id,
            'published_at' => Carbon::createFromFormat(DT_INPUT_FORMAT, $request->input('published_at'))
        ] + $request->only('title', 'body'));

        if ($request->has('tags')) {
            $article->tag($request->input('tags'));
        }

        Notification::success("Article created.");
        return redirect('admin/article');
    }

    /**
     * Display an edit article page.
     *
     * @param  Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $tags = implode(',',  $article->tagNames());
        $published_at = !empty($article->published_at)
            ? $article->published_at->format(DT_INPUT_FORMAT)
            : Carbon::now()->format(DT_INPUT_FORMAT);

        return view('admin.article.edit', compact('article', 'tags', 'published_at'));
    }

    /**
     * Update an article.
     *
     * @param  Article  $article
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Article $article, Request $request)
    {
        $this->validate($request, $this->rules);

        $article->update([
            'published_at' => Carbon::createFromFormat(DT_INPUT_FORMAT, $request->input('published_at'))
        ] + $request->only('title', 'body'));

        if ($request->has('tags')) {
            $article->retag($request->input('tags'));
        }

        Notification::success("Article updated.");
        return redirect('admin/article');
    }
}
