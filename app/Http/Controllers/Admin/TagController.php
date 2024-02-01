<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::latest()->get();
        return view('admin.tags.index')->with([
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        if ($request->validated()) {
            Tag::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect()->route('admin.tags.index')->with([
                'success' => 'Tag added successfully'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
        return view('admin.tags.edit')->with([
            'tag' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        //
        if ($request->validated()) {
            $tag->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect()->route('admin.tags.index')->with([
                'success' => 'Tag updated successfully'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        //
        $tag->delete();

        return redirect()->route('admin.tags.index')->with([
            'success' => 'Tag deleted successfully'
        ]);
    }
}
