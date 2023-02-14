<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComments extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'status',
        'author',
        'email',
        'body',
    ];

    public function post(){
        return $this->belongsTo('App\Models\Post','post_id');
    }

    public function replyPostComments(){
        return $this->hasMany('App\Models\PostCommentsReplies','comment_id');
    }

}
