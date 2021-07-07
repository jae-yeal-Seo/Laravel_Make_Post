<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $name = "일지매";
        $age = 23;
        return view('test.show', compact('name', 'age'));
    }
}
