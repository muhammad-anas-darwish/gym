<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO add filter & sort

        $articles = Article::select('user_id', 'title', 'article_photo_path')->paginate(10);

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

        return response()->json(
            $article->makeHidden('user_id')
            ->load([
                'category',
                'user' => function ($query) {
                    $query->select('id', 'name');
                }
            ])
        );
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
