<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all articles from db
        $articles = Article::all();
        // create body preview
        foreach ($articles as $article) {
            $article['body'] = substr($article['body'], 0, 25) . '...';
        }
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //form input validation
        $request->validate($this->validationParam());

        // get data and create a slug
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');

        /**
         * check for the presence of the image and store locally
         * save the path into $data
         */
        if(!empty($data['path_img'])) {
            $data['path_img'] = Storage::disk('public')->put('images', $data['path_img']);
        }

        // create a new article instance with $data from input form
        $newArticle = new Article();
        $newArticle->fill($data);

        // check if saving to db goes well
        $saved = $newArticle->save();
        if($saved) {
            return redirect()->route('articles.index');
        } else {
            return redirect()->route('home');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Validation function
     */
    private function validationParam() {
        return [
            'title' => 'required | unique:articles',
            'body' => 'required',
            'author' => 'required | max:50',
            'path_img' => 'image'
        ];
    }
}
