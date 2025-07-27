<?php

namespace App\Http\Controllers;

use App\Models\posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = posts::withTrashed()->latest()->paginate(10);

        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200|unique:posts,title',
            'slug' => 'required|string|max:200|unique:posts,slug',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id','thumbnail' => 'nullable|string|max:255',
            'status' => 'required|in:publish,draft',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = posts::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'thumbnail' => $request->thumbnail,
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = posts::find($id);

        return response()->json($post ?: ['message' => 'Post not found'], $post ? 200 : 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200|unique:posts,title,',
            'slug' => 'required|string|max:200|unique:posts,slug,',
            'content' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = posts::find($id);

        $post->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
        ]);

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = posts::find($id);

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
