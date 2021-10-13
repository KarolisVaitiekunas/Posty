@extends('layouts.app')

@section("content")
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            {{$user->name}}
        </div>
        @if($posts->count())
            @foreach($posts as $post)
                <div class="mb-4">
                    {{--                        here we will access $post and then -> to the method we created which allows us to get the user //Post.php line 16--}}
                    <a href="{{route('users.posts', $post->user)}}" class="font-bold">{{$post->user->name}}</a>
                    <span class="text-gray-600 text-sm">{{$post->created_at->diffForHumans()}}</span>
                    <p class="mb-2">{{$post->body}}</p>

                    @if($post->ownedBy(auth()->user()))
                        <div>
                            <form action="{{route('posts.destroy', $post)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-500">Delete</button>
                            </form>
                        </div>
                    @endif


                    <div class="flex items-center">
                        @auth
                            @if(!$post->likedBy(auth()->user()))
                                <form action="{{route("posts.likes", $post)}}" method="post" class="mr-1">
                                    @csrf
                                    <button type="submit" class="text-blue-500">Like</button>
                                </form>
                            @else
                                <form action="{{route("posts.likes", $post)}}" method="post" class="mr-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-blue-500">Unlike</button>
                                </form>

                            @endif
                        @endauth
                        <span>{{$post->likes->count()}} {{Str::plural('like', $post->likes->count())}}</span>
                    </div>
                </div>
            @endforeach
            {{$posts->links()}}
        @else
            <p>{{$user->name}} does not have any posts.</p>
        @endif
    </div>
@endsection
