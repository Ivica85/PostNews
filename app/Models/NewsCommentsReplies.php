<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCommentsReplies extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'status',
        'author',
        'email',
        'body',
    ];

    public function newsComments(){
        return $this->belongsTo('App\Models\NewsComments','comment_id');
    }
}
