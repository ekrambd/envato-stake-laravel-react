<?php
 namespace App\Repositories\Auth;

 interface AuthInterface
 {
 	public function userSignup($request);
 	public function userSignin($request);
 	public function userDetails();
 	public function userSignout($request);
 	public function adminLogin($request);
 	public function adminLogout($request);
 }