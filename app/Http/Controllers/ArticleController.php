<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\News;

class ArticleController extends Controller
{
    //enforcing user authentication
    public function __construct()
    {
        $this->middleware('auth:api')->only(['post_article', 'update', 'destroy']);
    }

    // post article linked to news
    public function post_article(Request $request, News $news){
        $request->validate([
            'content' => 'required|string',
        ]);

        $article = new Article();
        $article->content = $request->content;
        $article->news_id = $news->id;
        $article->save();

        return response()->json($article, 201);
    }
}
