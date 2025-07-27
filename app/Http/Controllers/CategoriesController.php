<?php

namespace App\Http\Controllers;

use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = categories::withTrashed()->latest()->paginate(5);

        return response()->json($categories);
    }

    public function getActiveCategories()
    {
        $categories = categories::latest()->paginate(5);

        return response()->json($categories);
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

        $categories = categories::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return response()->json($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categories = categories::find($id);

        return response()->json($categories);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(categories $categories)
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

        $categories = categories::find($id);

        $categories->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return response()->json($categories);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categories = categories::find($id);

        $categories->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
