<div style="margin: 30px; text-align: center;">
    @if(Session::has('comment_message'))
        <div class="alert alert-success" style="display: inline-block; width: 50%; padding: 20px; border-radius: 10px;">
            <p style="font-size: 18px;">{{Session('comment_message')}}</p>
        </div>
    @elseif(Session::has('update_message'))
        <div class="alert alert-success" style="display: inline-block; width: 50%; padding: 20px; border-radius: 10px;">
            <p style="font-size: 18px;">{{Session('update_message')}}</p>
        </div>
    @elseif(Session::has('delete_message'))
        <div class="alert alert-danger" style="display: inline-block; width: 50%; padding: 20px; border-radius: 10px;">
            <p style="font-size: 18px;">{{Session('delete_message')}}</p>
        </div>
    @elseif(Session::has('reply_message'))
        <div class="alert alert-success" style="display: inline-block; width: 50%; padding: 20px; border-radius: 10px;">
            <p style="font-size: 18px;">{{Session('reply_message')}}</p>
        </div>
    @elseif(Session::has('delete_reply'))
        <div class="alert alert-danger" style="display: inline-block; width: 50%; padding: 20px; border-radius: 10px;">
            <p style="font-size: 18px;">{{Session('delete_reply')}}</p>
        </div>
    @elseif(Session::has('update_reply'))
        <div class="alert alert-success" style="display: inline-block; width: 50%; padding: 20px; border-radius: 10px;">
            <p style="font-size: 18px;">{{Session('update_reply')}}</p>
        </div>
    @endif
</div>
