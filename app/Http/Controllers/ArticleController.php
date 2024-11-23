<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Services\Articles\ArticleService;

class ArticleController extends Controller
{
    public function __construct(private ArticleService $articleService)
    {
        // 
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = $this->articleService->getAll();

        return $this->successResponse(ArticleResource::collection($articles));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $data = $request->validated();

        $article = $this->articleService->store($data);
        
        return $this->successResponse(new ArticleResource($article), 201, 'Article added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $this->articleService->getArticle($article);

        return $this->successResponse(new ArticleResource($article));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $data = $request->validated();

        $this->articleService->update($article, $request, $data);

        return $this->successResponse(new ArticleResource($article), 200, 'Article updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->articleService->destroy($article);
        return $this->successResponse(code: 204, message:'Records deleted.');
    }
}
