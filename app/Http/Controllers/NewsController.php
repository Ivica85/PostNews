<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsFormRequest;
use App\Http\Requests\PostFormRequest;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);

        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(NewsFormRequest $request, $id = null)
    {
        auth()->user()->news()->updateOrCreate(
            ['id' => $id],
            [
                'title' => $request->title,
                'content' => $request->content,
            ]
        );

        return redirect()->route('news.index')->with('success', 'New Article Created!');
    }

    public function edit($id)
    {
        $article = News::findOrFail($id);

        return view('news.edit', compact('article'));
    }

    public function update(NewsFormRequest $request,  $id = null)
    {
        $news = News::findOrFail($id);
        if(auth()->user()->is_admin){
            $input = [
                'title' => $request->title,
                'content' => $request->content,
            ];
            $news->update($input);

        }else{
            auth()->user()->news()->where('id', $id)->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }

        return redirect()->route('news.index')->with('success', 'Article Updated!');

    }

    public function destroy($id)
    {
        News::destroy($id);

        return redirect()->route('news.index')->with('success', 'Article Deleted!');
    }
}
