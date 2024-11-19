<?php 

namespace App\Services\Articles;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    public function getArticles()
    {
        return Article::filter()
            ->select(['id', 'title', 'views_count', 'article_photo_path', 'user_id', 'category_id', 'created_at', 'updated_at']) 
            ->with(['user', 'category'])    
            ->paginate(18);
    }

    public function store(Request $request, array $data)
    {
        $data['user_id'] = Auth::id();

        if ($request->hasFile('article_photo'))
            $data['article_photo_path'] = $request->file('article_photo')->store('/images/articles', ['disk' => 'public']);

        $article = Article::create($data);

        $article->load(['user', 'category']);
        return $article;
    }

    public function getArticle(Article $article)
    {
        $article->increment('views_count');
        $article->load(['user', 'category']);
    }

    public function update(Article $article, $request, $data)
    {
        $data['user_id'] = Auth::id();

        if ($request->hasFile('article_photo'))
            $data['article_photo_path'] = $request->file('article_photo')->store('/images/articles', ['disk' => 'public']);

        $article->update($data);

        $article->load(['user', 'category']);
    }

    public function destroy(Article $article)
    {
        $article->delete();

    }
}