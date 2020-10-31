@extends('layouts.app')

@section('content')

    <div class="card card-default">
        <div class="card-header"> 
            {{ isset($category) ? 'Edit Category' : 'Create Category' }} <!-- isset check a value if it has value or null. here, the category is already existed when we want to edit it, but there is no category yet when we want to create it  -->
        </div>

        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST"> 
                <!-- if there is existing category, go to update path with its current dynamic url, if not, go to store path -->
                @csrf
                
                <!-- since form can only do action on GET or POST, use that kind of method to tell laravel to do method PUT instead -->
                @if(isset($category))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control" name="name" value="{{ isset($category) ? $category->name : '' }}">
                </div>
                <div class="form-group">
                    <button class="btn btn-success">{{ isset($category) ? 'Update Category' : 'Add Category' }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection