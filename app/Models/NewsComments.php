<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsComments extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'status',
        'author',
        'email',
        'body',
    ];

    public function news(){
        return $this->belongsTo('App\Models\News','news_id');
    }

    public function replyNewsComments(){
        return $this->hasMany('App\Models\NewsCommentsReplies','comment_id');
    }
}
