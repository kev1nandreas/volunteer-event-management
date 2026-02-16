<?php

namespace App\Http\Controllers;

use OpenApi\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SwaggerController extends Controller
{
    /**
     * Generate the OpenAPI JSON documentation
     */
    public function generateJson()
    {
        $openapi = Generator::scan([
            app_path('Http/Controllers'),
            base_path('docs')
        ]);

        return response()->json($openapi);
    }

    /**
     * Display the Swagger UI
     */
    public function ui()
    {
        return view('swagger.index');
    }

    /**
     * Get the cached OpenAPI JSON
     */
    public function getJson()
    {
        $storagePath = storage_path('api-docs');
        $jsonPath = $storagePath . '/api-docs.json';

        // Check if cached file exists
        if (File::exists($jsonPath)) {
            $json = File::get($jsonPath);
            return response($json)->header('Content-Type', 'application/json');
        }

        // Generate and cache if not exists
        $openapi = Generator::scan([
            app_path('Http/Controllers'),
            base_path('docs')
        ]);

        // Create storage directory if it doesn't exist
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        // Cache the JSON
        $json = $openapi->toJson();
        File::put($jsonPath, $json);

        return response($json)->header('Content-Type', 'application/json');
    }

    /**
     * Clear the cached documentation
     */
    public function clearCache()
    {
        $jsonPath = storage_path('api-docs/api-docs.json');
        
        if (File::exists($jsonPath)) {
            File::delete($jsonPath);
            return response()->json([
                'success' => true,
                'message' => 'API documentation cache cleared successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No cache file found'
        ], 404);
    }
}
