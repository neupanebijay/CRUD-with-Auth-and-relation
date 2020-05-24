@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Blog Create</div>

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
                 

                    <form action="{{route('blogs.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <p>
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title">
                        </p>
                        <p>
                        <label for="desc">Description</label>
                        <textarea name="description" class="form-control" id="desc" cols="30" rows="10"></textarea>
                        </p>
                         <p>

                        <label for="">Upload Image</label><br>
                        <input type="file"  name="image" id="">                
                         </p> 
                        
                         <input type="submit" value="Add" class="btn btn-secondary">
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
