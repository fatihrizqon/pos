<?php
namespace App\Http\Controllers; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\userRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\resetPassword;
use App\Models\User;
use Validator;
use Firebase\JWT\JWT; 
Use Carbon\Carbon;

class AuthController extends Controller
{
  public function __construct(){}

  public function register(Request $request)
  {
    $validator = Validator::make($request->all(),[
      'name'       => ['required', 'string', 'max:50'],
      'username'   => ['required', 'string', 'max:25', 'unique:users'],
      'gender'     => ['required', 'string', 'max:6'],
      'email'      => ['required', 'string', 'email', 'max:30', 'unique:users'], 
      'password'   => ['required','string', 'min:6']
    ]);

    if($validator->fails()) {
      $error = $validator->errors()->first();
      return response()->json([
        'success' => false,
        'message' => $error
      ], 403);
    }

    try {
      $user = User::create([
        'name'               => ucwords(strtolower($request->name)),
        'username'           => strtolower($request->username), 
        'email'              => strtolower($request->email),
        'gender'             => strtolower($request->gender),
        'password'           => Hash::make($request->password), 
        'verification_token' => Str::random(20),
       ]);
   
       if($user){
         // Sending Email Verification
         // Mail::to($user['email'])
         // ->send(new userRegistered($user)
         // );
   
         return response()->json([
           'success'   => true,
           'message'   => 'You are registered!',
           'data'      => $user
         ], 200);
       }
   
       return response()->json([
         'success' => false,
         'message' => "An error has been occured.",
       ], 404);  
    } catch(\Exception $e){
      return response()->json([
          'success' => false,
          'message' => $e
      ], 403);
    }
  }
 
  public function login(Request $request)
  { 
    $this->validate($request, [
      'username' => 'required',
      'password' => 'required'
    ]);

    $user = User::where('username', $request->input('username'))->first();

    if (!$user) {
      return response()->json([
        'success'=> false,
        'message'=> 'Username does not exists.' 
      ], 404); 
    }
    
    if(Hash::check($request->input('password'), $user->password)){
      $payload = [  
        'uid' => [
          'id' => $user->id,
          'username' => $user->username,
          'role' => $user->role
        ],  
        'iat' => intval((time()*1000)), 
        'exp' => intval((time()*1000) + (60 * 60 * 1000))
      ];

      $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
      if($token){
        return response()->json([
          'success'=> true,
          'message'=> 'You are logged in.',
          'access_token'=> $token 
        ], 200); 
      }
      return response()->json([
        'success'=> false,
        'message'=> 'An Error has been occured.'
      ], 400); 
    }

    return response()->json([
      'success'=> false,
      'message'=> 'Username and/or Password does not match.' 
    ], 400); 

  }

  public function profile()
  {
    return response()->json([
      'success'=> true,
      'message'=> 'Profile...' 
    ], 200); 
  }

  public function update(Request $request)
  {
    return response()->json([
      'success'=> true,
      'message'=> 'Update Profile...' 
    ], 200); 
  }
 
  public function verify($verification_token, $id)
  {
    $user = User::find($id);
    if ($user['verification_token'] != $verification_token) {
      return redirect('login')->with('invalid', 'Invalid Token.');
    }

    if($user['email_verified_at'] != null) {
      return response()->json([
        'success' => false,
        'message' => 'Your account already verified.'
      ], 400);
    }
    else{
      $user->role = '1';
      $user->email_verified_at = date('Y-m-d H:i:s');
      $user->save();

      return response()->json([
        'success' => true,
        'message' => 'Your account has been verified.'
      ], 200);
    }
  }
 
  public function reverify(Request $request)
  {
    $this->validate($request, [
      'email' => 'required',
    ]);

    $email = $request->input('email');
    $user = User::where('email', $email)->first();

    if($user['email_verified_at'] != null){
      return response()->json([
        'success' => false,
        'message' => 'Your account already verified.'
      ], 400);
    }
    
    Mail::to($user['email'])
    ->send(new userRegistered($user)
    );

    return response()->json([
      'success' => true,
      'message' => 'New Verification link has been sent to your registered Email.'
    ], 200);
  }
 
  public function recovery(Request $request)
  {
    $this->validate($request, [
      'email' => 'required',
    ]);
    $email = $request->email;
    $user = User::where('email', $email)->first();
    if($user){
      $recovery_password = str_random(6);
      $user->password = bcrypt($recovery_password);
      $user->save();
      Mail::to($user['email'])
      ->send(new resetPassword($user, $recovery_password)
      );
      return response()->json([
        'success' => true,
        'message' => 'Your Password Recovery has been sent to your registered Email.'
      ], 200);
    }
    return response()->json([
      'success' => false,
      'message' => 'Email does not exists!'
    ], 404);
  }

  public function logout(Request $request)
  {
    try {
      return response()->json([
        'success'=> true,
        'message'=> 'You are succesfully logged out.', 
      ], 200); ;

    } catch (JWTException $e) {
        return response()->json([
          'success' => false,
          'error' => 'An Error has been occured.'
        ], 500);
    }
 

  }
}
