<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Action;

class ActionController extends Controller
{
    public function getActions() {

        $date = date('Y-m-d');

        return response()->json([
            'data' => [
                'items' => Action::where('action_start', '<=', $date)->where('action_end', '>=', $date)->orderBy('action_start', 'desc')->get(),
            ],
        ]);

    }
}