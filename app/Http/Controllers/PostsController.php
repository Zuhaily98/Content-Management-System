<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostRequest;


class PostsController extends Controller
{
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
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        //upload image to storage
        //dd($request->image->store('posts'));
        $image = $request->image->store('posts');

        //create post
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'published_at' => $request->published_at
        ]);

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
        return view('posts.create')->with('post', $post);
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
        $post = Post::withTrashed()->where('id', $id)->firstorFail(); //firstofFail is for laravel to catch if user try to delete non existing data


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
        $trashed = Post::withTrashed()->get();  //fetch all the post even the one that had been trashed

        return view('posts.index')->withPosts($trashed);    //withPosts($trashed) is equal to with('posts', $trashed)
    }
}
