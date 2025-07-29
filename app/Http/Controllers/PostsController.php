<?php

namespace App\Http\Controllers;

use App\Models\posts;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = posts::with('tags')->withTrashed()->latest()->paginate(10);

        return response()->json($posts);
    }

    public function listForPublic()
    {
        $posts = posts::with('tags')->where('status', 'publish')->latest()->paginate(10);

        return response()->json($posts);
    }

    public function showDetailedSlug($slug){

        $post = posts::with('tags', 'user')->where('slug', $slug)->first();

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post);
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
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:publish,draft',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();

        $validatedData = $validator->validated();

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('posts', 'public');
            $validatedData['thumbnail'] = $path;
        }

        $post = posts::create($validatedData);

        if (isset($validatedData['tags'])) {
            $post->tags()->sync($validatedData['tags']);
        }

        $post->load('tags');

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = posts::with('tags')->find($id);

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
        $post = posts::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:200', Rule::unique('posts')->ignore($id)],
            'slug' => ['required', 'string', 'max:200', Rule::unique('posts')->ignore($id)],
            'content' => 'sometimes|required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'sometimes|required|in:publish,draft',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();

        if ($request->hasFile('thumbnail')) {
            $oldThumbnail = $post->getRawOriginal('thumbnail');
            if ($oldThumbnail) {
                Storage::disk('public')->delete($oldThumbnail);
            }

            $path = $request->file('thumbnail')->store('posts', 'public');
            $validatedData['thumbnail'] = $path;
        }
        // ------------------------------------------

        $post->update($validatedData);

        if (isset($validatedData['tags'])) {
            $post->tags()->sync($validatedData['tags']);
        }

        $post->load('tags');

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = posts::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $thumbnailPath = $post->getRawOriginal('thumbnail');

        if ($thumbnailPath) {
            Storage::disk('public')->delete($thumbnailPath);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
