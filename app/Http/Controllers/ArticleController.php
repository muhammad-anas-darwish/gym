<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $articles = Article::query();

        // filter by title & description
        if ($request->query('title')) {
            $articles = $articles->where('title', 'LIKE', '%'.$request->query('title').'%')
                ->orWhere('description', 'LIKE', '%'.$request->query('title').'%');
        }

        // filter by category id
        if ($request->query('category_id')) {
            $articles->filterByCategory($request->query('category_id'));
        }

        // filter by user id
        if ($request->query('user_id')) {
            $articles->filterByUser($request->query('user_id'));
        }

        // sort by created at or views_count attribute
        if ($request->query('sort_by') === 'created_at') {
            $articles->orderBy('created_at', 'desc');
        } elseif ($request->query('sort_by') === 'views_count') {
            $articles->orderBy('views_count', 'desc');
        }

        $articles = $articles->with(['user:id,name', 'category'])
            ->select('id', 'title', 'article_photo_path', 'views_count', 'user_id', 'category_id')
            ->paginate(10);

        return response()->json($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        if ($request->hasFile('article_photo'))
            $data['article_photo_path'] = $request->file('article_photo')->store('/images/articles', ['disk' => 'public']);

        Article::create($data);

        return response()->json(['message' => 'Article added.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article['views_count'] += 1;
        $article->save();

        $article = $article->load(['user:id,name', 'category']);

        return response()->json($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        if ($request->hasFile('article_photo'))
            $data['article_photo_path'] = $request->file('article_photo')->store('/images/articles', ['disk' => 'public']);

        $article->update($data);

        return response()->json(['message' => 'Article updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
