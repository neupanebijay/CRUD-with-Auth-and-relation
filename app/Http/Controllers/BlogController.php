<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('auth')->except(['index','create']);
        $this->middleware('auth')->only(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //    $blogs = Blog::all();
    /**
     * when Blog::all() is done it gives n+1 problems though it producs 100% correct result so use the following
     * blog uses user id and therefore access all info of user
     */
        $blogs = Blog::with('user')->get();
        

       return view('blogs.index')->with('blogs',$blogs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required | min:5',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            
          
             
        $blog                = new Blog;
        $blog->title         = $request->title;
        $blog->description   = $request->description;
        
        $blog->image         = $imageName ;
        $blog->user_id      = Auth::user()->id;
        $blog->save();
        return redirect(route('blogs.create'))->with('status', 'Record added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
