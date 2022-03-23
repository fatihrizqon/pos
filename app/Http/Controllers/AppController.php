<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    /*
        Product and Stock Controller has done.
    */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => "Index of App"
        ], 200);
    }
}
