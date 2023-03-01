<?php

namespace App\Http\Controllers;

use App\Mail\SignUp;
use App\Models\Post;
use App\Models\PostComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PostsCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postComments = PostComments::paginate(4);
        //  $postComments = PostComments::all();
        return view('comments/postsComments.index',compact('postComments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


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

        $post = Post::find($request->post_id);
        $user = Auth::user();
        $data = [
            'post_id' => $request->post_id,
            'author'  => $user->name,
            'email'   => $user->email,
            'body'    => $request->body
        ];


        PostComments::create($data);

        $msg = "Your post has being commented!";
        $email = $post->author->email;
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

        $comment = PostComments::findOrFail($id);
        $data = $request->all();
        $comment->update($data);
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
        $comment = PostComments::findOrFail($id);
        $input = $request->all();
        $comment->update($input);

        if($comment->status == 1){
            $name = $comment->name;
            $msg = "Hello $name, Your comment is approved. Thanks for commenting.";
            //Mail::to($comment->email)->send(new SignUp($msg));     //send email to author...
        }


        return redirect('dashboard/postComments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PostComments::findOrFail($id)->delete();
        return redirect('dashboard/postComments');
    }

    public function delete($id)
    {
        PostComments::findOrFail($id)->delete();
        Session::flash('delete_message','Your comment has been deleted.');
        return redirect()->back();

    }
}
