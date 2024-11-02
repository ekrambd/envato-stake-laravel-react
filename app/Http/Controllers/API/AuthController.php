<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Auth\AuthInterface;

class AuthController extends Controller
{   
	protected $auth;
	public function __construct(
		AuthInterface $auth
	)
	{
		$this->auth = $auth;
	}
    public function userSignup(Request $request)
    {
    	$userSignup = $this->auth->userSignup($request);
    	return $userSignup;
    }

    public function userDetails()
    {
    	$user = $this->auth->userDetails();
    	return $user;
    }

    public function userSignin(Request $request)
    {
        $userSignin = $this->auth->userSignin($request);
        return $userSignin;
    }

    public function userSignout(Request $request)
    {
        $userSignout = $this->auth->userSignout($request);
        return $userSignout;
    }

    public function adminLogin(Request $request)
    {
        $adminLogin = $this->auth->adminLogin($request);
        return $adminLogin;
    }

    public function adminLogout(Request $request)
    {
        $adminLogout = $this->auth->adminLogout($request);
        return $adminLogout;
    }
}
