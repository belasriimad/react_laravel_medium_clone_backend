<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\File;
use App\Http\Resources\ArticleResource;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    /**
     * Fetch all the article
     */
    public function index()
    {
        return ArticleResource::collection(Article::published()->latest()->paginate(2));
    }

    /**
     * Store new article
     */
    public function store(StoreArticleRequest $request) {
        if ($request->validated()) {
            //save the image and get the file name
            $file = $request->file('image');
            $file_name = $this->saveImage($file);

            //save the article
            $article = Article::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'body' => $request->body,
                'excerpt' => $request->excerpt,
                'image' => 'storage/articles/images/'.$file_name,
                'user_id' => $request->user()->id,
            ]);
            //store article's tags
            if (!empty($request->tags)) {
                $tags = explode(',', $request->tags);
                $article->tags()->sync($tags);
            }
            //return the response
            return response()->json([
                'message' => 'Article has been saved successfully and will be published soon.'
            ]);
        }
    }

    /**
     * Save images in the storage
     */
    public function saveImage($file)
    {
        $file_name = time().'_'.'article'.'_'.$file->getClientOriginalName();
        $file->storeAs('articles/images/', $file_name, 'public');
        return $file_name;
    }

    /**
     * Show article
     */
    public function show(Article $article)
    {
        //if the article does not exists return 404
        if (!$article->published()) {
            abort(404);
        }
        //return the article
        return ArticleResource::make($article);
    }

    /**
     * Update article
     */
    public function update(UpdateArticleRequest $request, Article $article) {
        if ($request->validated()) {
            if ($request->has('image')) {
                //remove the previous article image
                if (File::exists($article->image)) {
                    File::delete($article->image);
                }
                //save the new article image and get the file name
                $file = $request->file('image');
                $article->image = 'storage/articles/images/'.$this->saveImage($file);
            }

            //save the article
            $article->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'body' => $request->body,
                'excerpt' => $request->excerpt,
                'user_id' => $request->user()->id,
                'published' => 0
            ]);
            //update article's tags
            if (!empty($request->tags)) {
                $tags = explode(',', $request->tags);
                $article->tags()->sync($tags);
            }
            //return the response
            return response()->json([
                'user' => UserResource::make($request->user()),
                'message' => 'Article has been updated successfully and will be published soon.'
            ]);
        }
    }

    /**
     * Delete article
     */
    public function delete(Request $request, Article $article) {
        if ($article->user_id === $request->user()->id) {
            //remove the article image
            if (File::exists($article->image)) {
                File::delete($article->image);
            }
            //remove the article from the database
            $article->delete();
            //return the response
            return response()->json([
                'user' => UserResource::make($request->user()),
                'message' => 'Article has been deleted.'
            ]);
        }else {
            //return the response
            return response()->json([
                'error' => 'Something went wrong try again later.'
            ]);
        }
    }

    /**
     * Increment article's claps count
     */
    public function articleClap(Article $article) {
        //Increment article's claps count by 1
        $article->increment('clapsCount');
        return ArticleResource::make($article);
    }

    /**
     * Fetch articles by tags
     */
    public function fetchByTag(Tag $tag) {
        return ArticleResource::collection($tag->articles()->published()->paginate(2));
    }

    /**
     * Fetch articles by user
     */
    public function fetchByUser(Request $request) {
        return ArticleResource::collection($request->user()->articles()->latest()->get());
    }

    /**
     * Fetch followings articles
     */
    public function fetchFollowingsArticles(Request $request) {
        $articles = Article::whereIn('user_id', $request->user()->followings->pluck('id'))
            ->published()->paginate(2);
        return ArticleResource::collection($articles);
    }

    /**
     * Find articles
     */
    public function fetchByTerm(Request $request) {
        $searchTerm = $request->searchTerm;
        $articles = Article::where('title', 'like', '%'.$searchTerm.'%')
            ->published()->get();
        return ArticleResource::collection($articles);
    }
}
