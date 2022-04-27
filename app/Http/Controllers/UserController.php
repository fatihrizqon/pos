<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index( )
    {
        $users = User::get();

        if($users){
            return response()->json([
                'success'   => true,
                'message'   => 'Users Data has been loaded.',
                'data'      => $users
            ], 200);
        }
        return response()->json([
           'success'   => false,
           'message'   => 'Unable to load Users Data.' 
        ], 403);
    }

    public function view($id)
    {
        $user = User::find($id);

        if($user){
         return response()->json([
            'success'   => true,
            'message'   => 'Selected User has been loaded.',
            'data'      => $user
          ], 200);
        }

        return response()->json([
           'success'   => false,
           'message'   => 'User not found.'
         ], 404);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[ 
            'role' => ['required', 'integer'],
        ]);
      
        if($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => false,
                'message' => $error
            ], 403);
        }
        try {
            $user = User::find($id);
            $user->role = $request->role;
            if($user->save()){
                return response()->json([
                    'success' => true,
                    'message' => "Selected User has been updated.",
                    'data'    => $user
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => "Failed to update selected User." 
            ], 404);
        } catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ], 403);
        }
    }

    public function delete($id)
    {
        // $user = User::find($id)->delete();
        $user = false;

        if($user){
            return response()->json([
                'success' => true,
                'message' => "Selected User has been deleted."
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to delete selected User." 
        ], 404);
    }
}
