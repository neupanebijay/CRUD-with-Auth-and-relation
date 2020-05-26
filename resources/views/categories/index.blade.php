@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Categories </div>

                

                <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-info">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{route('categories.store')}}" method="post" class="mb-3">
                    @csrf
                    Category name: <input type="text" name="name" id="">
                    <input type="submit" value="Add">
                    
                    </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>name</th>
                                    
                                    <th>Number of Blogs </th>
                                    <th>Created on</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($categories as $category)

                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->name}}</a></td>
                                    {{--blog ma gayera khojne category_id should be equal to category->id --}}
                                    <td>{{ $category->no_of_blogs }}</td>
                                    <td>{{$category->created_at->diffForHumans()}}</td>
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
