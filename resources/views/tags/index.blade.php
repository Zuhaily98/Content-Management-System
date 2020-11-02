@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('tags.create') }}" class="btn btn-success">Add tag</a>
    <!-- here, use route or name of the route instead of /tag/create because that url may want to change later. by useing route or route name, no need to change at other place if the url is changed  -->
</div>

<div class="card card-default">
    <div class="card-header">Tags</div>
    <div class="card-body">
        @if ($tags->count()>0)
        <table class="table">
            <thead>
                <th>Name</th>
                <th>Post Count</th>
                <th></th>
            </thead>

            <tbody>
                @foreach($tags as $tag)
                <tr>
                    <td>
                        {{ $tag->name }}
                    </td>
                    <td>
                        {{ $tag->posts->count() }}
                    </td>
                    <td>
                        <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-info btn-sm">
                            Edit
                        </a>

                        <!-- when user click on this button, a function on javaScript will open the modal below -->
                        <button class="btn btn-danger btn-sm"
                            onclick="handleDelete({{ $tag->id }})">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <form action="" method="POST" id="deleteTagForm">
            <!-- the action has to be empty bcs we want to generate it with javascript via form id -->
            <!-- Modal -->
            @csrf
            @method('DELETE')
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Tag</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center text-bold">
                                Are you sure you want to delete this tag?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Go back</button>
                            <button type="submit" class="btn btn-danger">Yes, delete!</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @else 
            <h3 class="text-center">No Tags yet</h3>
        @endif

    </div>
</div>

@endsection

@section('scripts')

<script>
function handleDelete(id) {
    
    var form = document.getElementById('deleteTagForm')
    form.action = '/tags/' + id
    // console.log('deleting.', id)
    $('#deleteModal').modal('show')
}
</script>

@endsection