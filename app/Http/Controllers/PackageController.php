<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $package = Package::all();

        return response()->json($package);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request)
    {
        $data = $request->validated();

        // store
        Package::create($data);

        return response()->json(['message' => 'Package added.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        return response()->json($package);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        $data = $request->validated();

        // update
        $package->update($data);

        // redirect
        return response()->json(['message' => 'package updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        // delete
        $package->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
