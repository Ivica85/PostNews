<?php

namespace App\Http\Controllers;

use App\Mail\SignUp;
use App\Models\PostComments;
use App\Models\PostCommentsReplies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class  PostsRepliesCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        $post = PostComments::find($request->comment_id);
        $user = Auth::user();
        $data = [
            'comment_id' => $request->comment_id,
            'author'  => $user->name,
            'email'   => $user->email,
            'body'    => $request->body
        ];


        PostCommentsReplies::create($data);

        $msg = "Your comment has received reply!";
        $email = $post->email;
        //Mail::to($email)->send(new SignUp($msg));

        Session::flash('reply_message','Your reply has been submitted and is waiting moderation.');
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

        $postComment = PostComments::findOrFail($id);
        $postCommentsReplies = $postComment->replyPostComments;
        return view('comments/postsComments/replies.index',compact('postCommentsReplies'));
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

        $reply = PostCommentsReplies::findOrFail($id);
        $input = $request->all();
        $reply->update($input);
        Session::flash('update_reply','Your reply has been successfully updated.');
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
        $reply = PostCommentsReplies::findOrFail($id);
        $input = $request->all();
        $reply->update($input);

        if($reply->status == 1){
            $name = $reply->name;
            $msg = "Hello $name, Your comment is approved. Thanks for commenting.";
            //Mail::to($comment->email)->send(new SignUp($msg));     //send email to author...
        }


        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PostCommentsReplies::findOrFail($id)->delete();
        return redirect()->back();
    }

    public function delete($id)
    {
        PostCommentsReplies::findOrFail($id)->delete();
        Session::flash('delete_reply','Your comment reply has been deleted.');
        return redirect()->back();
    }
}
