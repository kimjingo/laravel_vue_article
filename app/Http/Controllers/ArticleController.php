<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Article;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $articles = Article::where('created_at', '<', 'now() - interval 1 day')->orderBy('id', 'DESC')->paginate(15);
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);
        return ArticleResource::collection($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = $request->isMethod('put') ? Article::findOrFail($request->id) : new Article ;

        $article->id = $request->input('id');
        $article->title = $request->input('title');
        $article->body = $request->input('body');
        
        if($article->save()){
            return new ArticleResource($article);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
         
        return new ArticleResource($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = $request->isMethod('put') ? Article::findOrFail($id) : new Article ;

        $article->title = $request->input('title');
        $article->body = $request->input('body');
        
        if($article->save()){
            return new ArticleResource($article);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
         
        if($article->delete()){
            return new ArticleResource($article);
        }
    }
}
