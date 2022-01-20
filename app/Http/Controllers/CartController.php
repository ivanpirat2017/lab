<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analyses;
use App\Models\Research_object;
use App\Http\Resources\AnalysisResource;
use App\Http\Resources\CostOfTakingBiomaterialResource;
use App\Http\Resources\ResearchObjectResource;

class CartController extends Controller
{
    public function get(Request $request)
    {
        $analysesInCart = Analyses::whereIn('id', json_decode($request->cart))->get();
        $researchObjectIds = collect(CostOfTakingBiomaterialResource::collection($analysesInCart))->toArray();
        return response()->json([
            'data' => [
                'analyses' => AnalysisResource::collection($analysesInCart),
                'paid_research_objects' => ResearchObjectResource::collection(Research_object::whereIn('id', $researchObjectIds)->where('cost_of_taking', '>', '0')->get())
            ],
        ]);
    }
}
