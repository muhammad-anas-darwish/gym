<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Models\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $videos = Video::query();

        $filter = new Filter($videos);
        $filter->search([
            'title' => $request->query('q'),
            'description' => $request->query('q')
            ])
            ->whereHasByColumn('user', 'name', $request->query('user_name'))
            ->whereHas('user', 'user_id', $request->query('user_id'))
            ->orderBy(['created_at', 'views'], $request->query('sort_by'), 'desc');

        $videos = $videos->with('user:id,name')->paginate(8);

        return response()->json($videos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('thumbnail_photo')) // store image
            $data['thumbnail_photo_path'] = $request->file('thumbnail_photo')->store('/images/videos', ['disk' => 'public']);
        if ($request->hasFile('video')) // store video
            $data['video_path'] = $request->file('video')->store('/videos/videos', ['disk' => 'public']);

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

        return response()->json($video->load(['user:id,name']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail_photo')) // store image
            $data['thumbnail_photo_path'] = $request->file('thumbnail_photo')->store('/images/videos', ['disk' => 'public']);
        if ($request->hasFile('video')) // store video
            $data['video_path'] = $request->file('video')->store('/videos/videos', ['disk' => 'public']);

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
