<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\StartupNameGenerator;

class StartupNameGeneratorController extends Controller
{
    private StartupNameGenerator $generator;
    
    public function __construct(StartupNameGenerator $generator)
    {
        $this->generator = $generator;
    }
    
    public function generateStartupName(Request $request): JsonResponse
    {
        $count = $request->input('count', 5);
        $count = min(max((int)$count, 1), 20); // Limit between 1-20
        
        $names = $this->generator->generate($count);
        
        return response()->json([
            'success' => true,
            'data' => [
                'count' => count($names),
                'names' => $names
            ]
        ]);
    }
}
