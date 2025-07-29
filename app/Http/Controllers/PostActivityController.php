<?php

namespace App\Http\Controllers;

use App\Models\PostActivity;
use App\Models\posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\post;

class PostActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($postId)
    {
        $post = posts::find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $activities = PostActivity::where('post_id', $postId)->latest()->paginate(10);

        return response()->json($activities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = posts::where('id', $request->post_id)->where('status', 'publish')->first();

        if (!$post) {
            return response()->json(['message' => 'Post not found or not published'], 404);
        }

        $activity = PostActivity::create([
            'post_id' => $post->id,
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        return response()->json([
            'message' => 'Activity logged successfully',
            'data' => $activity,
        ], 201);
    }

}
