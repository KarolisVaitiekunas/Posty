<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable =[
        'body'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }


    //check if user_id is inside user id (if user has liked post)
    //will return true/false depending if the user has liked
    public function likedBy(User $user){
        return $this->likes->contains('user_id', $user->id);
    }

    //check if post is owned by the authenticated user
    public function ownedBy(User $user){
        return $user->id === $this->user_id;
    }
}
