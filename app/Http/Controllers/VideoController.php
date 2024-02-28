<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO add fiter and sorting
        $videos = Video::paginate(8);

        return response()->json($videos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        Video::create($data);

        return response()->json(['message' => 'Video added.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        $video['views'] += 1;
        $video->save();

        return response()->json($video->makeHidden('user_id')->load(['user' => function($query) {
            $query->select('id', 'name');
        }]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        $data = $request->validated();

        $video->update($data);

        return response()->json(['message' => 'Video updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $video->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
