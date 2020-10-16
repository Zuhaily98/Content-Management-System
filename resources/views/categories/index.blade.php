@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('categories.create') }}" class="btn btn-success">Add Category</a> <!-- here, use route or name of the route instead of /category/create because that url may want to change later. by useing route or route name, no need to change at other place if the url is changed  -->
    </div>

    <div class="card card-default">
        <div class="card-header">Categories</div>
        <div class="card-body">
           <table class="table">
            <thead>
                <th>Name</th>
            </thead>

            <tbody>
                @foreach($categories as $category)
                   <tr>
                    <td>
                        {{ $category->name }}
                    </td>
                   </tr> 
                @endforeach
            </tbody>
           </table> 
        </div>
    </div>

@endsection