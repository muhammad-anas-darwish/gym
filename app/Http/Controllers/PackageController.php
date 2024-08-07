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
        $packages = Package::with('specialties')->get();

        return response()->json($packages);
    }

    public function getActivePackages()
    {
        $packages = Package::with('specialties')->active()->get();

        return response()->json($packages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request)
    {
        $data = $request->validated();
        $specialties = isset($data['specialties'])? $data['specialties']: null;
        unset($data['specialties']);

        $package = Package::create($data);
        if (!is_null($specialties)) {
            $package->specialties()->attach($specialties);
        }

        return $this->respondOk('Package added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        return response()->json($package->load('specialties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        $data = $request->validated();
        $specialties = isset($data['specialties'])? $data['specialties']: null;
        unset($data['specialties']);

        $package->update($data);
        if (!is_null($specialties)) {
            $package->specialties()->sync($specialties);
        }

        return $this->respondOk('Package updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return $this->respondOk('Package Deleted.');
    }
}
