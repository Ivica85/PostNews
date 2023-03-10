<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function newsComments(){
        return $this->hasMany('App\Models\NewsComments','news_id');
    }
}
