<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analyses;
use App\Http\Resources\AnalysisResource;

class AnalysesController extends Controller
{
    public function search(Request $request)
    {
        $query = $_GET['query'] ?? '';

        if ($query == '') $items = []; else $items = AnalysisResource::collection(Analyses::where('analysis_name', 'like', '%' . $query . '%')->get());

        return response()->json([
            'data' => [
                'items' => $items
            ],
        ]);
    }
}
