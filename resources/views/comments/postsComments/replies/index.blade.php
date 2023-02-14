<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{"Post Replies"}}
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
            <th class="px-4 py-2">Approve comment</th>
            <th class="px-4 py-2">Delete comment</th>
        </tr>
        </thead>
        <tbody>
        @foreach($postCommentsReplies as $postCommentsReply)
            <tr class="bg-gray-100">
                <td class="border px-4 py-2">{{$postCommentsReply->postComments->post_id}}</td>
                <td class="border px-4 py-2">{{$postCommentsReply->author}}</td>
                <td class="border px-4 py-2">{{$postCommentsReply->email}}</td>
                <td class="border px-4 py-2">{{$postCommentsReply->body}}</td>
                <th class="px-4 py-2"><a  href="{{route('post.show',$postCommentsReply->postComments->post_id)}}">View post</a></th>



                @if($postCommentsReply->status == 1)
                    <form method="POST" action="{{route('postRepliesComment.update',$postCommentsReply->id)}}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="0">
                        <td class="border px-4 py-2">
                            <button class="bg-red-400 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Un-approve</button>
                        </td>
                        </td>

                    </form>
                @else

                    <form method="POST" action="{{route('postRepliesComment.update',$postCommentsReply->id)}}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="1">
                        <td class="border px-4 py-2">
                            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approve</button>
                        </td>

                    </form>
                @endif
                <form method="POST" action="{{route('postRepliesComment.delete',$postCommentsReply->id)}}">
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


</x-app-layout>
