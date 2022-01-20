<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Analyses;
use App\Models\Research_object;
use App\Models\Order;
use App\Http\Resources\ResearchTemplateResource;
use App\Http\Resources\CostOfTakingBiomaterialResource;
use App\Http\Resources\ResearchObjectResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderInfoResource;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $analysesInCart = Analyses::whereIn('id', json_decode($request->cart))->get();
        $sumAnalysesInCart = $analysesInCart->sum('price');

        Order::create([
            'user_id' => Auth::user()->id,
            'order_date' => date('d.m.Y'),
            'price' => $sumAnalysesInCart + $this->getArrayResearchObjects($analysesInCart)->sum('cost_of_taking'),
            'research_result' => ResearchTemplateResource::collection($analysesInCart)->toJson(JSON_UNESCAPED_UNICODE)
        ]);

        return response()->json()->setStatusCode(204);
    }

    public function getArrayResearchObjects($analysesInCart)
    {
        $researchObjectIds = collect(CostOfTakingBiomaterialResource::collection($analysesInCart))->toArray();
        return ResearchObjectResource::collection(Research_object::whereIn('id', $researchObjectIds)
            ->where('cost_of_taking', '>', '0')->get());
    }

    public function search(Request $request)
    {
        $query = $_GET['query'] ?? '';
        $query = $_GET['query'] ?? '';
        return response()->json([
            'data' => [
                'items' => OrderResource::collection(Order::where('id', 'like', '%' . $query . '%')->orWhere('order_date', 'like', '%' . $query . '%')->orWhere('research_result', 'like', '%' . $query . '%')->orderBy('created_at', 'desc')->get())
            ],
        ]);
    }

    public function getOrderInfo(Request $request, $orderId)
    {
        $orderInfo = OrderInfoResource::collection(Order::where('id', $orderId)->where('user_id', Auth::user()->id)->where('order_status_id', '3')->get());
        if (empty(collect($orderInfo)->toArray()))
            return response()->json([
                'error' => [
                    'code' => 404,
                    'message' => 'Not Found'
                ]
            ], 404);
        return response()->json([
            'data' => [
                'user_info' => [
                    'name' => Auth::user()->last_name . ' ' . Auth::user()->first_name . ' ' . Auth::user()->patronymic,
                    'birthdate' => date('d.m.Y', strtotime(Auth::user()->birthdate))
                ],
                'order_info' => $orderInfo
            ]
        ]);
    }

    public function delete($orderId)
    {
        $orderToDelete = Order::where('id', $orderId)->where('user_id', Auth::user()->id)->where('order_status_id', '1');
        if (empty(collect($orderToDelete->get())->toArray())) {
            return response()->json([
                'error' => [
                    'code' => 400,
                    'message' => 'Bad Request'
                ]
            ], 400);
        }

        $orderToDelete->delete();

        return response()->json()->setStatusCode(204);
    }
}
