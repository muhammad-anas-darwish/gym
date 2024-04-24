<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
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

        $filter = new Filter($articles);
        $filter->search([
            'title' => $request->query('q'),
            'description' => $request->query(('q')),
            ])
            ->where('category_id', $request->query('category_id'))
            ->where('user_id', $request->query('user_id'))
            ->orderBy(['created_at', 'views_count'], $request->query('sort_by'), 'desc');

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
