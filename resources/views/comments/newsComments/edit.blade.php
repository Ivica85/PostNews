<x-guest-layout>
    <div class="relative py-16 bg-white overflow-hidden">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:h-full lg:w-full">
            <div class="relative h-full text-lg max-w-prose mx-auto" aria-hidden="true">
                <svg class="absolute top-12 left-full transform translate-x-32" width="404" height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="74b3fd99-0a6f-4271-bef2-e80eeafdf357" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#74b3fd99-0a6f-4271-bef2-e80eeafdf357)" />
                </svg>
                <svg class="absolute top-1/2 right-full transform -translate-y-1/2 -translate-x-32" width="404" height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="f210dbf6-a58d-4871-961e-36d5016a0f49" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#f210dbf6-a58d-4871-961e-36d5016a0f49)" />
                </svg>
                <svg class="absolute bottom-12 left-full transform translate-x-32" width="404" height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="d3eb07ae-5182-43e6-857d-35c643af9034" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#d3eb07ae-5182-43e6-857d-35c643af9034)" />
                </svg>
            </div>
        </div>
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

                @if(count($post->postComments) > 0)
                    <div class="form-group">
                        <h5><i>READ COMMENTS:</i></h5>
                    </div>
                @elseif(count($post->postComments) == 0)
                    <div class="form-group">
                        <h5><i>BE THE FIRST TO COMMENT</i></h5>
                    </div>
                @endif

                @foreach($post->postComments as $comment)
                    @if($comment->status == 1)
                        <div class="card card-body shadow-sm mt-3">
                            <div class="detail-area">
                                <h6 class="user-name mb-1">
                                    <h4>{{$comment->author}}</h4>
                                    <small class="ms-3 text-primary">Commented on: {{$comment->created_at}}</small>
                                </h6>
                                <p class="user-comment mb-1">
                                    {{$comment->body}}
                                </p>
                            </div>
                        </div>

                        <div class="comment-reply-container">


                            <button class="toggle-reply btn btn-primary pull-left">Reply</button>

                            <div class="comment-reply"  style="display: none;">
                                <form action="{{route('createComment')}}" method="post">
                                    @csrf

                                    <input type="hidden" name="comment_id" value="{{$comment->id}}">

                                    <div class="form-group">
                                        <textarea class='form-control' rows="1" name="body"></textarea>

                                        <div class="form-group">
                                            <button class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    @endif

                @endforeach


                @if(count($errors)>0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div class="comment-area mt-24">
                    <h4>Leave a Comment:</h4>
                    <form action="{{route('createComment')}}" method="POST" >
                        @csrf

                        <input type="hidden" name="post_id" value="{{$post->id}}">

                        <div class="form-group">
                            <textarea class="form-control" name="body" rows=3></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                @if(Session::has('comment_message'))
                    <div class="alert alert-success col-sm-15">
                        <p>{{Session('comment_message')}}</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <script>

        $(".comment-reply-container .toggle-reply").click(function(){
            $(this).next().slideToggle("slow");
        });
    </script>
</x-guest-layout>
