<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REST API methods
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return Post::orderBy('post_id', 'desc')->paginate(10);
    }
 
    public function get($id)
    {
        return Post::find($id);
    }

    public function post(Request $request)
    {
        $row = Post::create($request->all());
        return response()->json($row, 201);
    }

    public function put($id, Request $request)
    {
        $row = Post::findOrFail($id);
        $row->update($request->all());
        return response()->json($row, 200);
    }

    public function delete($id)
    {
        $row = Post::findOrFail($id);
        $row->delete();
        return response()->json(null, 204);
    }
}
