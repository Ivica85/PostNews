<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class NewsCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $newsComments = NewsComments::paginate('4');

       return view('comments/newsComments.index',compact('newsComments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'body'=>'required|min:2|max:2000'
        ]);

        $article = News::find($request->news_id);
        $user = Auth::user();
        $data = [
            'news_id' => $request->news_id,
            'author'  => $user->name,
            'email'   => $user->email,
            'body'    => $request->body
        ];


        NewsComments::create($data);

        $msg = "Your post has being commented!";
        //$email = $article->author->email;
//        Mail::to($email)->send(new SignUp($msg));

        Session::flash('comment_message','Your comment has been submitted and is waiting moderation.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request,[
            'body'=>'required|min:2|max:2000'
        ]);

        $newsComment = NewsComments::findOrFail($id);
        $data = $request->all();
        $newsComment->update($data);
        Session::flash('update_message','Your comment has been successfully updated.');
        return redirect()->back();
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
        $newsComment = NewsComments::findOrFail($id);
        $input = $request->all();
        $newsComment->update($input);

        if($newsComment->status == 1){
            $name = $newsComment->name;
            $msg = "Hello $name, Your comment is approved. Thanks for commenting.";
            //Mail::to($newsComment->email)->send(new SignUp($msg));     //send email to author...
        }


        return redirect('dashboard/newsComments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        NewsComments::findOrFail($id)->delete();

        return redirect('dashboard/newsComments');
    }

    public function delete($id)
    {
        NewsComments::findOrFail($id)->delete();

        Session::flash('delete_message','Your comment has been deleted.');
        return redirect()->back();

    }
}
