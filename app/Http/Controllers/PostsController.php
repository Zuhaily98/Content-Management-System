<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostRequest;



class PostsController extends Controller
{
    public function __construct () //install middleware for verify existance of categories before enabling user to create new post
    {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']); //this middleware is only applied on create and store function
        
        return redirect('categories.create');
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all()); //fetch all post data in db and the data is fetch using the key 'posts'
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all()); //also invite Category so that we get all of categories record
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        //dd($request->all());
        //upload image to storage
        //dd($request->image->store('posts'));
        $image = $request->image->store('posts');

        //create post
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'published_at' => $request->published_at,
            'category_id' => $request->category //category here is because the name of select option is category
        ]);

        if($request->tags){
            $post->tags()->attach($request->tags); //because belongs to many relationship, the selected tag(s) will be attached to the newly created post
        }

        //flash message
        session()->flash('success', 'Post created successfully!');

        //redirect
        return redirect(route('posts.index'));
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
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title', 'description', 'published_at', 'content']); //not request for all data for security purposes
        
        //check for new image 
        if($request->hasFile('image')) {
            //upload it
            $image = $request->image->store('posts');
            //delete old one
            $post->deleteImage(); //using function delete in model Post

            $data['image'] = $image;
        } 

        if($request->tags){
            $post->tags()->sync($request->tags);  //sync is a function for many to many relationship - check request if theres new tag thats is not attached, then it will be attached and otherwise
        }

        //update attributes
        $post->update($data);

        //flash message
        session()->flash('success', 'Post updated successfully!');

        //redirect
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //without using route model binding
        $post = Post::withTrashed()->where('id', $id)->firstOrFail(); //firstofFail is for laravel to catch if user try to delete non existing data


        if($post->trashed())
        {
            $post->deleteImage();
            $post->forceDelete();
        }
        else
        {
            $post->delete(); //soft delete first before permanently delete in list of trashed posts 
        }

        session()->flash('success', 'Post thrashed successfully!');

        return redirect(route('posts.index'));
    }

    /**
     * Soft delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();  //fetch only the post  that had been trashed

        return view('posts.index')->withPosts($trashed);    //withPosts($trashed) is equal to with('posts', $trashed)
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstorFail();

        $post->restore();

        session()->flash('success', 'Post restored successfully!');

        return redirect(route('posts.index'));
    }
}
