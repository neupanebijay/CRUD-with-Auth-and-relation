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
        $this->middleware('auth');
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
     * BLog has relation with user as relation "user" and with category "category"
     */
    //  latest()->get() keeps data in desc order  
     $blogs = Blog::with('user','category')->get();
        
       

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
            'category_id' =>'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            
          
             
        $blog                   = new Blog();
        $blog->title            = $request->title;
        $blog->category_id      = $request->category_id;
        $blog->description      = $request->description;
        
        $blog->image            = $imageName ;
        $blog->user_id          = Auth::user()->id;
        $blog->save();
        return redirect(route('blogs.create'))->with('status', 'Record added');

            // use mass assignemnt for all the following tchniques except the above.
        /**
         * instead of the above eloquent data we can use database as well but we need to define in model as well
         */

        // Blog::create([
        //     'title' => $request->title,
        //     'description' => $request->description,       
        //      'image'         = $imageName ;
        //     'user_id'      = Auth::user()->id;

            /**
             * blogs below is a relation name
             */
    // Auth::user()->blogs()->create([
    //     'title' => $request->title,
    //         'description' => $request->description,     
    //         'category_id'  => $request->category_id,

    //          'image'         => $imageName,
    //         'user_id'      => Auth::user()->id,
    //     ]);
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
        return view('blogs.edit',compact('blog'));
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
        $request->validate([
            'title' => 'required | min:5',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

            
            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);
                $blog->image         = $imageName ;
            }
          
             
        $blog->title         = $request->title;
        $blog->description   = $request->description;
        
        
        $blog->user_id      = Auth::user()->id;
        $blog->save();
        return redirect(route('blogs.index'))->with('status', 'Record updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        if($blog->user->id == Auth::user()->id){
           
            unlink( public_path('/images/'.$blog->image));
            $blog->delete();

            return redirect(route('blogs.index'))->with('status', 'Record Deleted');
        }
        
        return redirect(route('blogs.index'))->with('status', 'Delete yours blog only, You are not permitted to delete others blog');
         
    }

    public function ownBlogs()
    {
        // means blog user id is user with logged in. blog ma vako user id vaneko login gareko user_id ho 
        $blogs = Blog::where('user_id', Auth::user()->id)->get();
        return view('blogs.index')->with('blogs',$blogs);


    }
}
