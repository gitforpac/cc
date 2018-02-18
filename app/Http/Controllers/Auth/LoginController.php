<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function sendLoginResponse(Request $request)
    {
        $user = $this->getUserDetails($request->email);

        return response()->json([
                'authenticated' => true,
                'email' => $user->email,
                'name' => $user->name,
                'id' => $user->id
             ], 200 );  
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
                'authenticated' => false,
             ], 401);   
    }

    private function getUserDetails($email) 
    {
        return $user = User::where('email', $email)
                            ->first();

    }
}
