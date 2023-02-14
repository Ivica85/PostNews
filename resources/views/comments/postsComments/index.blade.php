<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{"Post Comments"}}
        </h2>
    </x-slot>

        <table class="table-auto w-full text-left">
            <thead class="bg-gray-800 text-white">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Author</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Comment</th>
                <th class="px-4 py-2">Post link</th>
                <th class="px-4 py-2">Replies link</th>
                <th class="px-4 py-2">Approve comment</th>
                <th class="px-4 py-2">Delete comment</th>
            </tr>
            </thead>
            <tbody>
            @foreach($postComments as $comment)
            <tr class="bg-gray-100">
                <td class="border px-4 py-2">{{$comment->post_id}}</td>
                <td class="border px-4 py-2">{{$comment->author}}</td>
                <td class="border px-4 py-2">{{$comment->email}}</td>
                <td class="border px-4 py-2">{{$comment->body}}</td>
                <th class="px-4 py-2"><a  href="{{route('post.show',$comment->post_id)}}">View post</a></th>
                <th class="px-4 py-2"><a href="{{route('postRepliesComment.show',$comment->id)}}">View replies</a></th>


                @if($comment->status == 1)
                <form method="POST" action="{{route('postComment.update',$comment->id)}}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="0">
                <td class="border px-4 py-2">
                    <button class="bg-red-400 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Un-approve</button>
                </td>
                </td>

                </form>
                @else

                    <form method="POST" action="{{route('postComment.update',$comment->id)}}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="1">
                        <td class="border px-4 py-2">
                            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approve</button>
                        </td>

                    </form>
                @endif
                <form method="POST" action="{{route('postComment.delete',$comment->id)}}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="status" value="0">
                    <td class="border px-4 py-2">
                        <button class="bg-red-700 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                    </td>
                    </td>

                </form>
            </tr>
            @endforeach
            </tbody>

        </table>

    <div class="pagination-container text-center mx-auto mt-24" style="display: flex; justify-content: center;">
        <div class="pagination">
            {{$postComments->links()}}
        </div>
    </div>



</x-app-layout>
