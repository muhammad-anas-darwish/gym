<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use App\Http\Requests\StoreAdviceRequest;
use App\Http\Requests\UpdateAdviceRequest;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $advices = Advice::query();

        // filters
        if ($request->query('title')) {
            $advices = $advices->where('title', 'LIKE', '%' . $request->query('title') . '%');
        }

        if ($request->query('category_id')) {
            $advices = $advices->where('category_id', $request->query('category_id'));
        }

        $advices = $advices->select('id', 'title', 'category_id')
            ->with('category')
            ->paginate(20);

        return response()->json($advices);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdviceRequest $request)
    {
        $data = $request->validated();

        Advice::create($data);

        return response()->json(['message' => 'Advice added.'], 201);
    }

    /**
     * Display the random resource.
     */
    public function getRandomAdvice()
    {
        $randomAdvice = Advice::inRandomOrder()->select('title')->first();

        return response()->json($randomAdvice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdviceRequest $request, Advice $advice)
    {
        $data = $request->validated();

        $advice->update($data);

        return response()->json(['message' => 'Advice updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advice $advice)
    {
        $advice->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
