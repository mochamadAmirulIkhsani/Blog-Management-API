<?php

namespace App\Http\Controllers;

use App\Models\tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = tags::withTrashed()->latest()->paginate(5);

        return response()->json($tags);
    }

    public function getActiveTags()
    {
        $tags = tags::latest()->paginate(5);

        return response()->json($tags);
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
            'name' => 'required|string|max:50|unique:categories,name',
            'slug' => 'required|string|max:50|unique:categories,slug',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tags = tags::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return response()->json($tags, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tags = tags::find($id);

        return response()->json($tags);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tags $tags)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $validator = Validator::make($request->all(),
        [
            'name' => 'required|string|max:50|unique:categories,name,',
            'slug' => 'required|string|max:50|unique:categories,slug,',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tags = tags::find($id);

        $tags->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return response()->json($tags);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tags = tags::find($id);

        $tags->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
