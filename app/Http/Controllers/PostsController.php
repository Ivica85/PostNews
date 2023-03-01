<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostFormRequest $request, $id = null)
    {
        auth()->user()->posts()->updateOrCreate(
            [ 'id' => $id ],
            [
                'title' => $request->title,
                'content' => $request->content,
            ]
        );

        return redirect()->route('post.index')->with('success', 'New Post Created!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    public function update(PostFormRequest $request,  $id = null)
    {

        $post = Post::findOrFail($id);
        if(auth()->user()->is_admin){
            $input = [
                'title' => $request->title,
                'content' => $request->content,
            ];
            $post->update($input);

        }else{
            auth()->user()->posts()->where('id', $id)->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }
        return redirect()->route('post.index')->with('success', 'Article Updated!');

    }

    public function destroy($id)
    {
        Post::destroy($id);

        return redirect()->route('post.index')->with('success', 'Post Deleted!');
    }
}
