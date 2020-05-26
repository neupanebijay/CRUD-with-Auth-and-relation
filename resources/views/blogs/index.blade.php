@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Blogs </div>

                

                <div class="card-body">
                    
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Created By </th>
                                    <th>Created on</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($blogs as $blog)

                                <tr>
                                    <td>{{$blog->id}}</td>
                                    <td><a href="{{route('blogs.show', $blog->id)}}">{{$blog->title}}</a></td>
                                    {{--this category name is from Blog model with CategoryNameAttribute--}}
                                    <td>{{$blog->category_name}}</td>
                                    {{-- <td>{{$blog->user_id}}</td> --}}
                                    {{-- <td>{{App\User::find($blog->user_id)->name}}</td> --}}
                                    <td>{{$blog->user->name}}</td>
                                    <td>{{$blog->created_at->diffForHumans()}}</td>
                                </tr>
                            @endforeach
                            </tbody>


                        </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
