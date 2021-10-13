<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function _construct(){
        //must be authenticated to like
        $this->middleware(['auth']);
    }

    public function store(Post $post, Request $request){


        //we created likedBy method in Post.php //it checks if current user has already liked the post
       if($post->likedBy($request->user())){
            return response(null, 409);
       }

        $post->likes()->create([
            'user_id'=> $request->user()->id
        ]);
        return back();
    }

    public function destroy(Post $post, Request $request){
        //delete like
        $request->user()->likes()->where('post_id', $post->id)->delete();
        return back();
    }
}
