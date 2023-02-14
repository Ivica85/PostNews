<x-guest-layout>
    <div class="relative py-16 bg-white overflow-hidden">
        <div class="relative px-4 sm:px-6 lg:px-8">
            <div class="text-lg max-w-prose mx-auto">
                <span class="block text-base text-center text-indigo-600 font-semibold tracking-wide uppercase">Post</span>
                <h1>
                    <span class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{ $post->title }}</span>
                </h1>
            </div>
            <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">
                <p>{!! nl2br(e($post->content)) !!}</p>
                <hr>

                <div class="form-group">
                    <h2>
                        <i style="color: #0c5460; font-style: normal; text-transform: uppercase; letter-spacing: 2px;">COMMENTS:</i>
                    </h2>
                </div>



                <?php
                session_start();
                $approvedComments = 0;
                ?>


                @foreach($post->postComments as $comment)
                    @if($comment->status == 1)
                            <?php $approvedComments++ ?>
                    @endif
                    @if($approvedComments>0 && $comment->status == 1)
                        <div class="detail-area d-flex flex-column" id="comment_{{$comment->id}}">
                            <h6 class="user-name mb-1">
                                <h4>{{$comment->author}}</h4>
                                <small class="ms-3 text-primary">Commented on: {{$comment->created_at->diffForHumans()}}</small>
                            </h6>
                            <p class="user-comment mb-1" id="comment_body_{{$comment->id}}">
                                {{$comment->body}}
                            </p>

                            <div class="d-flex" style="display: flex; align-items: center;">
                                <div class="comment-reply-container">
                                    <button style="margin-top: 10px" class="toggle-reply btn btn-primary pull-left mr-3 reply-edit-button ">Reply</button>
                                    <div class="comment-reply" style="display: none;">
                                        <form action="{{route('postRepliesComment.create')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                            <div class="form-group" style="width: 600px;">
                                                <textarea class='form-control' rows="3" name="body"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary reply-edit-button">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @auth
                                    @if(Auth::user()->name == $comment->author)
                                        <form action="{{route('postComment.edit', $comment->id)}}" method="post" id="edit_form_{{$comment->id}}" style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                            <textarea  style="width: 500px;" name="body" class="form-control" id="textarea_{{$comment->id}}">{{$comment->body}}</textarea>
                                            <button type="submit" class="btn btn-success mt-2 update-button">Update</button>
                                            <button class="btn btn-danger mt-2 cancel-button" id="cancel_{{$comment->id}}">Cancel</button>
                                        </form>
                                        <button class="btn btn-primary mr-2 edit-button" id="edit_{{$comment->id}}">Edit</button>
                                        <form action="{{route('commentOwner.delete', $comment->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete-button">Delete</button>
                                        </form>
                                    @endif
                                  @endauth
                            </div>
                        </div>

                        <script>

                            document.getElementById("edit_{{$comment->id}}").addEventListener("click", function() {
                                document.getElementById("comment_body_{{$comment->id}}").style.display = "none";
                                document.getElementById("edit_form_{{$comment->id}}").style.display = "block";
                            });
                            document.getElementById("cancel_{{$comment->id}}").addEventListener("click", function(event) {
                                event.preventDefault();
                                document.getElementById("comment_body_{{$comment->id}}").style.display = "block";
                                document.getElementById("edit_form_{{$comment->id}}").style.display = "none";
                            });

                        </script>


                    @endif


                        <div style="padding:10px"></div>
                        @if(count($comment->replyPostComments) > 0)
                            @php
                                $approvedRepliesCount = 0;
                                foreach ($comment->replyPostComments as $reply) {
                                    if ($reply->status == 1) {
                                        $approvedRepliesCount++;
                                    }
                                }
                            @endphp
                            @if($comment->replyPostComments()->count() > 0 && $approvedRepliesCount > 0 && $comment->status == 1 )
                                <button class="toggle-replies btn btn-primary pull-left mr-3">
                                    <i class="fas fa-caret-down arrow"></i>
                                    {{$approvedRepliesCount}}
                                    <span class="reply-text">@if($comment->replyPostComments()->count() == 1)
                                            <strong>reply</strong>
                                        @else
                                            <strong>replies</strong>
                                        @endif</span>
                                </button>
                            @endif

                            <div class="replies-container" style="display: none;">
                        @foreach($comment->replyPostComments as $reply)
                            @if($reply->status == 1)
                                <!-- Nested Comment -->
                                <div id='nested-comment' class="media ml-5">
                                    <div class="media-body">
                                        <h4 class="media-heading">{{$reply->author}}
                                            <small>{{$reply->created_at->diffForHumans()}}</small>
                                        </h4>
                                        <p class="user-comment mb-1" id="reply_comment_body_{{$reply->id}}">
                                            {{$reply->body}}
                                        </p>

                                        <div class="d-flex" style="display: flex; align-items: center;">
                                            <div class="comment-reply-container">
                                                <button style="margin-top: 10px" class="toggle-reply btn btn-primary pull-left mr-3 reply-edit-button ">Reply</button>
                                                <div class="comment-reply" style="display: none;">
                                                    <form action="{{route('postRepliesComment.create')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                                        <div class="form-group" style="width: 600px;">
                                                            <textarea class='form-control' rows="3" name="body"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn btn-primary reply-edit-button">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>


                                            @auth
                                                @if(Auth::user()->name == $reply->author)

                                                    <form action="{{route('postRepliesComment.update', $reply->id)}}" method="post" id="reply_edit_form_{{$reply->id}}" style="display: none;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <textarea  style="width: 500px;" name="body" class="form-control" id="textarea_{{$reply->id}}">{{$reply->body}}</textarea>
                                                        <button type="submit" class="btn btn-success mt-2 update-button">Update</button>
                                                        <button class="btn btn-danger mt-2 cancel-button" id="reply_cancel_{{$reply->id}}">Cancel</button>
                                                    </form>
                                                    <button class="btn btn-primary mr-2 edit-button" id="reply_edit_{{$reply->id}}">Edit</button>
                                                    <form action="{{route('postRepliesComment.delete',$reply->id)}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger delete-button">Delete</button>
                                                    </form>
                                                @endif
                                           @endauth
                                        </div>

                                        <script>
                                            document.getElementById("reply_edit_{{$reply->id}}").addEventListener("click", function() {
                                                document.getElementById("reply_comment_body_{{$reply->id}}").style.display = "none";
                                                document.getElementById("reply_edit_form_{{$reply->id}}").style.display = "block";
                                            });

                                            document.getElementById("reply_cancel_{{$reply->id}}").addEventListener("click", function (event) {
                                                event.preventDefault();
                                                document.getElementById("reply_comment_body_{{$reply->id}}").style.display = "block";
                                                document.getElementById("reply_edit_form_{{$reply->id}}").style.display = "none";
                                            });
                                        </script>


                                    </div>
                                </div>
                            @endif
                        @endforeach
                            </div>
                    @endif
                @endforeach


                <?php $_SESSION['approved_comments'] = $approvedComments; ?>

                @if($_SESSION['approved_comments'] == 0)
                    <div class="form-group">
                        <h5><i>BE THE FIRST TO COMMENT</i></h5>
                    </div>
                @endif

                @if(count($errors) > 0)
                    <div class="alert alert-danger"  style="display: inline-block; width: 50%; padding: 20px; border-radius: 10px;">
                        <ul style="list-style: none; padding: 0;">
                            @foreach($errors->all() as $error)
                                <li style="margin: 10px 0; color: #f44336; font-weight: 600;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                @include('includes/flash_messages')

                <div class="comment-area mt-24">
                    <h4 style="color: #0c5460; text-transform: uppercase; letter-spacing: 2px; font-weight: bold;">Leave a Comment:</h4>
                    <form action="{{route('postComment.create')}}" method="POST" >
                        @csrf

                        <input type="hidden" name="post_id" value="{{$post->id}}">

                        <div class="form-group">
                            <textarea class="form-control" name="body" rows=3></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary reply-edit-button">Submit</button>
                    </form>
                </div>

                <script>
                    // Store the current scroll position
                    window.addEventListener("beforeunload", function () {
                        localStorage.setItem("scrollPos", window.pageYOffset);
                    });

                    // Restore the scroll position after the page reloads
                    window.addEventListener("load", function () {
                        window.scrollTo(0, localStorage.getItem("scrollPos") || 0);
                    });
                </script>

                <script>
                    $(".comment-reply-container .toggle-reply").click(function(){
                        $(this).next().slideToggle("slow");
                    });
                </script>

                <script>
                    document.querySelectorAll('.toggle-replies').forEach(function(toggleButton) {
                        toggleButton.addEventListener('click', function() {
                            const replies = this.nextElementSibling;
                            replies.style.display = replies.style.display === 'none' ? 'block' : 'none';
                            const arrow = this.querySelector('.arrow');
                            arrow.classList.toggle('fa-caret-down');
                            arrow.classList.toggle('fa-caret-up');

                        });
                    });


                </script>





</x-guest-layout>























