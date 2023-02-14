<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCommentsReplies extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'status',
        'author',
        'email',
        'body',
    ];

    public function postComments(){
        return $this->belongsTo('App\Models\PostComments','comment_id');
    }
}
