<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $posts = Post::get();
        return $this->apiResponse($posts, 'Data Will Be Showing Sucessfully', 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 404);
        }

        $post = Post::create($request->all());
        if ($post) {
            return $this->apiResponse($post, 'Data Will Be saved Sucessfully', 201);
        }
        return $this->apiResponse(null, 'Data Will Be saved Not Sucessfully', 404);
    }


    public function show($id)
    {
        $post = new PostResource(Post::find($id));
        if ($post) {
            return $this->apiResponse($post, 'Data Will Be Showing Sucessfully', 200);
        }
        return $this->apiResponse(null, 'Data Will Be Showing Not Sucessfully', 401);
    }

//mo
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 404);
        }


        $post = Post::find($id);

        if (!$post) {
            return $this->apiResponse(null, 'Post Not Found', 404);
        }

        $post->update($request->all());

        if ($post) {
            return $this->apiResponse($post, 'Post Updated Sucessfully', 201);
        }

    }


    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->apiResponse(null, 'Post Not Found', 404);
        }

        $post->delete($id);

        if ($post) {
            return $this->apiResponse(null, 'Post Deleted Sucessfully', 201);
        }
    }
}
