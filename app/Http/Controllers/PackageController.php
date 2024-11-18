<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Services\Packages\PackageService;
use App\Services\Packages\PackageUpdateService;
use App\Services\Stripe\StripeManagerService;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class PackageController extends Controller
{
    public function __construct(
        protected PackageService $packageService, 
        protected StripeManagerService $stripeManagerService,
        protected PackageUpdateService $packageUpdateService,
    ) { }


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
        $specialties = $data['specialties'] ?? null;
        unset($data['specialties']);

        DB::beginTransaction();
        
        try {
            // Create Package
            $package = $this->packageService->createPackage($data, $specialties);
  
            // Create stripe product and price 
            $stripeProductAndPrice = $this->stripeManagerService->createProductWithPrice(
                $data['name'], 
                $data['description'], 
                $data['price'], 
                $data['duration'], 
                $data['is_active']
            ); 

            try {
                // Add stripe information to the package
                $package = $this->packageService->attachPackageWithStripe(
                    $package, 
                    $stripeProductAndPrice['product']->id, 
                    $stripeProductAndPrice['price']->id
                );
            } catch (Exception $e) {
                DB::rollBack();
                $this->stripeManagerService->deactivateProductAndPrice($stripeProductAndPrice['product']->id, $stripeProductAndPrice['price']->id);
                return $this->failedResponse('Failed to attach Stripe information to the package.', HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failedResponse('Failed to create the subscription plan. Please try again later.', HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
  
        DB::commit();

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
        $specialties = $request->specialties ?? null;

        try {
            $this->packageUpdateService->updatePackageWithStripe($package, $request->validated(), $specialties);

            return $this->respondOk('Package updated.');
        } catch (Exception $e) {
            return $this->failedResponse('Failed to update package', HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $this->stripeManagerService->deactivateProductAndPrice($package->stripe_product_id, $package->stripe_price_id);
        $this->packageService->deletePackage($package);

        return $this->respondOk('Package Deleted.');
    }
}
