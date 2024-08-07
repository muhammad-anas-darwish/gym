<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\Specialty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PackageControllerTest extends TestCase
{
    use RefreshDatabase; 
    
    public function testIndexReturnsPackagesWithSpecialties()
    {
        $package = Package::factory()->create();
        $specialty = Specialty::factory()->create();
        $package->specialties()->attach($specialty);

        $response = $this->getJson('/api/packages');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'title', 
                'description', 
                'limit', 
                'price',
                'is_active', 
                'specialties' => [
                    '*' => [
                        'id',
                        'name',
                    ]
                ]
            ]
        ]);

        info($package->is_active === null);
        $response->assertJsonFragment([
            'id' => $package->id,
            'title' => $package->title,
            'description' => $package->description,
            'limit' => $package->limit,
            'price' => $package->price,
            'is_active' => $package->is_active,

        ]);
    }
}
