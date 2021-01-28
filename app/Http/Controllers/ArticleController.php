<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Article;
use App\Tag;

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
        $articles = Article::orderBy('id', 'asc')->paginate(8);
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
        // get all tags to populate checkbox area in create view
        $tags = Tag::all();
        return view('articles.create', compact('tags'));
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
        $request->validate($this->validationParam(false));

        // get data and create a slug
        $data = $request->all();
        // dd($data['tags']);
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
            // check if the article has tags
            if(!empty($data['tags'])) {
                // add article_id to $data, then populate pivot table
                $data['article_id'] = $newArticle->id;
                $newArticle->tags()->attach($data['tags']);
            }
            return redirect()->route('articles.index');
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->first();
        $tags = Tag::all();

        // 404 if article is null
        if(empty($article)) {
            return abort(404);
        }

        return view('articles.show', compact('article', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $article = Article::where('slug', $slug)->first();
        $tags = Tag::all();
        // 404 if article is null
        if(empty($article)) {
            return abort(404);
        }

        return view('articles.edit', compact('article', 'tags'));
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
        // validation
        $request->validate($this->validationParam(true, $id));
        $data = $request->all();
        
        //get the article's record
        $article = Article::find($id);
        
        // create new slug
        $data['slug'] = Str::slug($data['title'], '-');

        // check if we have an image in input
        if(!empty($data['path_img'])) {
            // check if we already have an image stored in db
            if(!empty($article->path_img)) {
                // delete previous image
                Storage::disk('public')->delete($article->path_img);
            }
            // save new image and store new img path in data
            $data['path_img'] = Storage::disk('public')->put('images', $data['path_img']);
        }

        /**
         * check for selected tags
         * if some tags were provided, update pivot
         * if no tags were provided, delete every relations for that article
         */
        if(!empty($data['tags'])) {
            $article->tags()->sync($data['tags']);
        } else {
            $article->tags()->detach();
        }

        // update db record
        $updated = $article->update($data);

        // check if update goes well
        if($updated) {
            return redirect()->route('articles.show', $article->slug);
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
        // get record from db
        $article = Article::find($id);

        // get path image if an image is linked to the record
        $image = !empty($article->path_img) ? $article->path_img : false;
        // save a session reference
        $ref = $article->title;

        // delete record from db and related image locally
        $deleted = $article->delete();
        if($deleted) {
            if($image) {
                Storage::disk('public')->delete($image);
            }
            return redirect()->route('articles.index')->with('ref', $ref);
        }
    }

    /**
     * Validation function with title exception for updating a record
     */
    private function validationParam($update, $recordId = null) {
        if($update) {
            // set Rule exception for title if we are updating the record
            $title_rules = [
                'required',
                Rule::unique('articles')->ignore($recordId)
            ];
        } else {
            // title must be unique if we are not updating (so we are creating a new one)
            $title_rules = 'required | unique:articles';
        }
        // return the array 
        return [
            'title' => $title_rules,
            'body' => 'required',
            'author' => 'required | max:50',
            'path_img' => 'image'
        ];
    }
}