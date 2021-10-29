<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

use App\Http\Services\PostService;
use App\Http\Requests\CreatePostRequest;



class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(PostService $service)
    {
        $post = $service->getAll();
        return view('blog.index', ['posts' => $post]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request , PostService $service)
    {
        $service->create($request);
        return redirect('/blog')->with('message', 'Your post has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug, PostService $service)
    {
        $post = $service->getById($slug);
        return view('blog.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit(string $slug, PostService $service)
    {
        $post = $service->getById($slug);
        return view('blog.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',

        ]);
        Post::where('slug', $slug)
            ->update(
                [ 'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'slug' => $slug,
                    'user_id' => auth()->user()->id]
            );
        return redirect('/blog')
            ->with('message', 'Your post has been updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $slug , PostService $service)
    {
        $service->delete($slug);
        return redirect('blog')->with('message', 'Your post has been deleted!');
    }

}
