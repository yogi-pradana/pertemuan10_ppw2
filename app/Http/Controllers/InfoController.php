<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Hello Ganteng', 'success' => true], 200);
    }
}
