<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {

        $postsFromDB = Post::all();

        return view('posts.index', ['posts' => $postsFromDB]);
    }
    public function show(Post $post)
    {
        // $SinglePostFromDB = Post::findOrFail($postId);


        return view('posts.show', ['post' => $post]);
    }

    public function create()
    {
        //select * from users;
        $users = User::all();

        return view('posts.create', ['users' => $users]);
    }
    public function store()
    {
        request()->validate([
            'title' => ['required', 'min:5'],
            'description' => ['required', 'min:8'],
        ]);
        //1-get user data
        $data = request()->all();


        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->postCreator;

        //store in database
        Post::create([
            'title' => $title,
            'description' => $description,
            'user_id' => $postCreator,
        ]);

        //3-return to index home
        return to_route('posts.index');

    }

    public function edit(Post $post)
    {
        //select * from users;
        $users = User::all();

        return view('posts.edit', ['users' => $users, 'post' => $post]);
    }
    public function update($postId)
    {
        //1-get user data
        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->postCreator;


        //2-store in database

        $SinglePostFromDB = Post::find($postId);
        $SinglePostFromDB->update([
            'title' => $title,
            'description' => $description,
            'user_id' => $postCreator,
        ]);

        //3-return to index home
        return to_route('posts.show', $postId);
    }

    public function destroy($postId)
    {
        //1-delete data in DB
        $post = Post::findOrFail($postId);
        $post->delete();

        //2-redirect to posts.index
        return to_route('posts.index');
    }
}
