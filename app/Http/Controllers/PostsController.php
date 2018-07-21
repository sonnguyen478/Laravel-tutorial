<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// import DB
use App\Post;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts =  Post::all();

        // Get data by SQL command
        //$posts = DB::select('SELECT * from posts');

        // Get a single data
        //$posts = Post::orderBy('title','desc')->take(1)->get();

        // Order data by descendence order
        $posts = Post::orderBy('created_at','desc')->get();

        // Split the post by page
        $posts = Post::orderBy('title','desc')->paginate(10);

        return view('posts.index') -> with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=> 'required',
            'body'=> 'required',
            'cover_image'=>'image|nullable|max:1999',
        ]);

        // Handle file upload
        if ($request->hasFile('cover_image'))
        {
            // Get file name with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalImage();

            // Get just file name
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);

            // Get judt extension
            $extension = $request->file('cover_image')->getOriginalClientExtension();

            // File name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_image',$fileNameToStore);
        }
        else
        {
            $fileNameToStore = 'noImage.jpg';
        }

        // Create post
        $post = new Post;
        $post->title = $request->input('title');
        $post->contain = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show') -> with ('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        // Check for correct user
        if (auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts')->with('error','Unauthorized Page');
        }
        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title'=> 'required',
            'body'=> 'required',
        ]);

        // Edit post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->contain = $request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        // Check for correct user
        if (auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts')->with('error','Unauthorized Page');
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed');
    }
}
