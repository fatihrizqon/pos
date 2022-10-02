<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => "Updated 02/10/2022",
            'date' => date('Y-m-d H:i:s')
        ], 200);
    }
}
