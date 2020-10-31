<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.index')->with('tags', Tag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTagRequest $request)
    {
        /*$this->validate($request, [
            'name' => 'required|unique:Tags' //laravel will make sure no same data in the db 
        ]);*/

        //to use static methord create() to make a mass assignment, write a line in model Tag to tell laravel that this particular attribute is protected
        Tag::create([
            'name' => $request->name    
        ]);

        session()->flash('success', 'Tag created successfully!');

        return redirect(route('tags.index'));
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
    public function edit(Tag $tag) 
    {
        //dont want to create new view for edit/update since the form is similar to create view.
        //reuse create.blade.php instead

        return view('tags.create')->with('tag', $tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, Tag $tag) //Tag $Tag is the current dynamic property
    {
        //method 1
        // $Tag->name = $request->name;
        // $Tag->save();

        //method 2 - using update() function
        $tag->update([
            'name' => $request->name
        ]);


        session()->flash('success', 'Tag updated successfully!');

        return redirect(route('tags.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        session()->flash('success', 'Tag deleted successfully!');

        return redirect(route('tags.index'));
    }
}
