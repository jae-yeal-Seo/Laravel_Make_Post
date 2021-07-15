<?php

namespace App\Http\Controllers;

use App\Models\PostUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        $postusers = DB::table('post_user')
            ->select('post_id', 'posts.created_at', DB::raw('count(*) cnt,title'))
            ->join('posts', 'post_user.post_id', '=', 'posts.id')
            ->groupBy('post_id')
            ->orderByDesc('cnt')
            ->take(5)->get();
        // $postusers = PostUser::selectRaw('post_id, count(*) cnt, postusers.created_at, post_id, title')
        //     ->join('posts', 'post_users.post_id', '=', 'posts.id')
        //     ->groupBy('post_id')
        //     ->orderByDesc('cnt')
        //     ->take(5)->get();

        return view('chart.index')->with('postusers', $postusers);
    }
}
