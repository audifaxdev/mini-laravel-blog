@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">Posts</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="panel panel-default">
                            @if (count($posts) >= 0)
                                <table id="post-list" class=" table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($posts as $post)
                                        <tr onclick="editPost('{{$post->id}}')">
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->created_at }}</td>
                                            <td>{{ $post->updated_at }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert-required alert-primary fade show text-center m-3">
                                    No content found. Add your first post by clicking the button below.
                                </div>
                            @endif
                            <a class="btn btn-primary float-right" href="/admin/edit-post" >New Post</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function editPost (postId) {
            window.location = "/admin/edit-post/"+postId;
        }
        // document.addEventListener("DOMContentLoaded", function () {
        //     $(document).ready(function () {
                // $("#post-list tr>td:first-child").onclick();
            // });
        // })
    </script>
@endsection
