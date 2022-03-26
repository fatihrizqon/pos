<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => "Index of App",
            'date' => date('Y-m-d H:i:s')
        ], 200);
    }
}
