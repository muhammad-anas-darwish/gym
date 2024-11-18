<?php

namespace App\Http\Controllers;

use App\Http\Requests\Advice\StoreAdviceRequest;
use App\Http\Requests\Advice\UpdateAdviceRequest;
use App\Models\Advice;
use App\Http\Resources\AdviceResource;

class AdviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advices = Advice::filter()->with('category')->paginate();

        return $this->successResponse(AdviceResource::collection($advices));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdviceRequest $request)
    {
        $data = $request->validated();

        $advice = Advice::create($data);
        $advice->load('category');

        return $this->successResponse(new AdviceResource($advice), 201, 'Advice added.');
    }

    /**
     * Display the random resource.
     */
    public function getRandomAdvice()
    {
        $randomAdvice = Advice::inRandomOrder()->first();

        return $this->successResponse(new AdviceResource($randomAdvice));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdviceRequest $request, Advice $advice)
    {
        $data = $request->validated();

        $advice->update($data);
        $advice->load('category');

        return $this->successResponse(new AdviceResource($advice), message: 'Advice updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advice $advice)
    {
        $advice->delete();

        return $this->successResponse(message: 'Records deleted.', code: 204);
    }
}
