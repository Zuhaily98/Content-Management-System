@extends('layouts.app')

@section('content')

    <div class="card card-default">
        <div class="card-header"> 
            {{ isset($tag) ? 'Edit tag' : 'Create tag' }} <!-- isset check a value if it has value or null. here, the tag is already existed when we want to edit it, but there is no tag yet when we want to create it  -->
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-group">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item text-danger">
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ isset($tag) ? route('tags.update', $tag->id) : route('tags.store') }}" method="POST"> 
                <!-- if there is existing tag, go to update path with its current dynamic url, if not, go to store path -->
                @csrf
                
                <!-- since form can only do action on GET or POST, use that kind of method to tell laravel to do method PUT instead -->
                @if(isset($tag))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control" name="name" value="{{ isset($tag) ? $tag->name : '' }}">
                </div>
                <div class="form-group">
                    <button class="btn btn-success">{{ isset($tag) ? 'Update Tag' : 'Add Tag' }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection