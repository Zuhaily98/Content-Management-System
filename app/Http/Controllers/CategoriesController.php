<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index')->with('categories', Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        /*$this->validate($request, [
            'name' => 'required|unique:categories' //laravel will make sure no same data in the db 
        ]);*/

        //to use static methord create() to make a mass assignment, write a line in model Category to tell laravel that this particular attribute is protected
        Category::create([
            'name' => $request->name    
        ]);

        session()->flash('success', 'Category created successfully!');

        return redirect(route('categories.index'));
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
    public function edit(Category $category) 
    {
        //dont want to create new view for edit/update since the form is similar to create view.
        //reuse create.blade.php instead

        return view('categories.create')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category) //Category $category is the current dynamic property
    {
        //method 1
        // $category->name = $request->name;
        // $category->save();

        //method 2 - using update() function
        $category->update([
            'name' => $request->name
        ]);


        session()->flash('success', 'Category updated successfully!');

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->posts->count() > 0)
        {
            session()->flash('error', 'Categories cannot be deleted because it has some posts.');

            return redirect()->back();
        }

        $category->delete();

        session()->flash('success', 'Category deleted successfully!');

        return redirect(route('categories.index'));
    }
}
