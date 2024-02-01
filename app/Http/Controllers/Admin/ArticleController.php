<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->get();
        return view('admin.articles.index')->with([
            'articles' => $articles
        ]);
    }

    /**
     * Publish and unpublish articles
     */
    public function tooglePublishedStatus(Article $article, $published)
    {
        $article->update([
            'published' => $published
        ]);

        return redirect()->route('admin.articles.index')->with([
            'success' => 'Article has been updated successfully'
        ]);
    }

    /**
     * Delete article
     */
    public function destroy(Article $article)
    {
        //
        if (File::exists($article->image)) {
            File::delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with([
            'success' => 'Article has been deleted successfully'
        ]);
    }
}
