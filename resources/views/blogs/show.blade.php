@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$blog->title}} </div>

                    <div class="card-body">
                    {{-- the following !! is to allow us to use html tags--}}
                      {!! $blog->description !!}  <br>
                     <img src="/images/{{$blog->image}}" alt="" class="img-fluid"> 
                     <hr>
                      Posted by: {{$blog->user->name}} {{$blog->created_at->diffForHumans()}}<br>

                        <div class="btn-group">
                            <form onsubmit="return confirm('Are you sure??')" action="{{route('blogs.destroy',$blog->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete" class="btn btn-danger">
                            </form>
                            <a href="{{route('blogs.edit', $blog->id)}}" type="button" class="btn btn-primary ml-3">Edit</a>
                            
                        </div>
                               

                            
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection