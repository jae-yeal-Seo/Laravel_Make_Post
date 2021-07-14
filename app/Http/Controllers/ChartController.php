<?php

namespace App\Http\Controllers;

use App\Models\PostUser;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index()
    {
        $postusers = PostUser::selectRaw('post_id, count(*) cnt')
            ->groupBy('post_id')
            ->orderByDesc('cnt')
            ->take(6)->get();

        // dd($postusers);
        return view('chart.index')->with('postusers', $postusers);
    }
}
