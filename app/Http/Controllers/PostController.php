<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        //$posts = Post::get(); // will get back a collection, all of them
        $posts =Post::orderBy('created_at', 'desc')->paginate(2);
        //if we write like this we will EAGER LOAD the data
        //$posts = Post::with(['user', 'likes'])->paginate(20);

        //we send down posts to the view
        return view('posts.index', [
            'posts'=>$posts
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'body' => 'required'
        ]);
        //we create hasMany function in User.php // line 47

        //accesing users posts
        $request->user()->posts()->create([
            //auto fills user_id
            'body' => $request->body
        ]);

        return back();
    }

    public function destroy(Post $post){
        //if post not created by you, frick off
        if(!$post->ownedBy(auth()->user())){
            dd("HET");
        }
        $post->delete();
        return back();
    }
}
