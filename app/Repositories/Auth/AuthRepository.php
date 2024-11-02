<?php
 namespace App\Repositories\Auth;
 use App\Models\User;
 use App\Models\Balance;
 use Auth;
 use DB;
 use Image;
 use Validator;
 class AuthRepository implements AuthInterface
 {
 	public function userSignup($request)
 	{
 		try
 		{
 			$validator = Validator::make($request->all(), [
 				'name' => 'required|string|max:50',
 				'email' => 'required|email|unique:users',
 				'phone' => 'nullable|string|unique:users',
                'wallet_address' => 'required|string',
                'password' => 'required|string|min:6',
                'confirm_password' => 'required|string|min:6|same:password'
            ]);

            if($validator->fails()){
            	DB::commit();
                return response()->json(['status'=>false, 'message'=>'The given data was invalid', 'data'=>$validator->errors()],422);  
            }

            if($request->image){
        	   $position = strpos($request->image, ';');
               $sub=substr($request->image, 0 ,$position);
               $ext=explode('/', $sub)[1];
               $name=time().".".$ext;
               $img=Image::make($request->image);
               $upload_path='uploads/users/';
               $path=$upload_path.$name;
               $img->save($path);
            }else{
            	$path = "defaults/profile.png";
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->role_id = 3;
            $user->wallet_address = $request->wallet_address;
            $user->password = bcrypt($request->password);
            $user->image = $path;
            $user->save();

            $balance = new Balance();
            $balance->user_id = $user->id;
            $balance->balance = 0;
            $balance->save();

            $token = $user->createToken('MyApp')->plainTextToken;

            DB::commit();

            return response()->json(['status'=>true, 'user_id'=>intval($user->id), 'token'=>$token, 'message'=>'Successfully signup']);

 		}catch(Exception $e){
 			DB::rollback();
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()]);
 		}
 	}

 	public function userSignin($request)
 	{
 		try
 		{
 			$validator = Validator::make($request->all(), [
 				'wallet_address' => 'required|string',
 				'password' => 'required|string|min:6',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was invalid', 'data'=>$validator->errors()],422);  
            }

            $credentials = ['wallet_address' => $request->wallet_address, 'password' => $request->password];

            if(Auth::attempt($credentials)){ 
            	$user = user();
            	$token = $user->createToken('MyApp')->plainTextToken;
            	return response()->json(['status'=>true, 'user_id'=>intval($user->id), 'token'=>$token, 'message'=>'Successfully Sign in']);
            }

            return response()->json(['status'=>false, 'user_id'=>0, 'token'=>"", 'message'=>'Invalid Wallet Address Or Password'],500);

 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function userDetails()
 	{
 		try
 		{
 			$user = User::with(['balance','userpackage'])->findorfail(user()->id);
 			return response()->json(['status'=>true, 'data'=>$user]);
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()]);
 		}
 	}

 	public function userSignout($request)
 	{
 		user()->tokens()->delete();
    	return response()->json(['success'=>true, 'message'=>'Successfully Logged Out!']);
 	}

 	public function adminLogin($request)
 	{
 		try
 		{
 			$validator = Validator::make($request->all(), [
 				'user_name' => 'required|string',
 				'password' => 'required|string',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was invalid', 'data'=>$validator->errors()],422);  
            }

            $credentials = ['user_name' => $request->user_name, 'password' => $request->password];

            if(Auth::attempt($credentials)){ 
            	$user = user();
            	$token = $user->createToken('MyApp')->plainTextToken;
            	return response()->json(['status'=>true, 'user_id'=>intval($user->id), 'token'=>$token, 'message'=>'Successfully Logged In']);
            }

            return response()->json(['status'=>false, 'user_id'=>0, 'token'=>"", 'message'=>'Invalid Wallet Address Or Password'],500);

 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function adminLogout($request)
 	{
 		user()->tokens()->delete();
    	return response()->json(['success'=>true, 'message'=>'Successfully Logged Out!']);
 	}
 }