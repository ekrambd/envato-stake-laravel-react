<?php
 namespace App\Repositories\Package;
 use App\Models\Package;
 use App\Models\Service;
 use Validator;
 use DB;

 class PackageRepository implements PackageInterface
 {
 	public function fetch($request)
 	{
 		try
 		{
 			$query = Package::query();
 			if($request->has('title'))
 			{   
 				$search = $request->title;
 				$query->where('packages.title', 'LIKE', "%$search%");
 			}
 			$packages = $query->select('*');
 			return $packages;
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function store($request)
 	{
		DB::beginTransaction();

 		try
 		{   

 			$validator = Validator::make($request->all(), [
 				'category_id' => 'required',
 				'title' => 'required|string|max:191',
 				'price' => 'required',
 				'stake_duration' => 'required',
 				'interest_rate' => 'required',
 				'status' => 'required|in:Active,Inactive',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was invalid', 'data'=>$validator->errors()],422);  
            }
		
			
 			$package = Package::create([
 				'user_id' => user()->id,
 				'category_id' => $request->category_id,
 				'title' => $request->title,
 				'price' => $request->price,
 				'stake_duration' => $request->stake_duration,
 				'interest_rate' => $request->interest_rate,
 				'status' => $request->status,
 			]);
			
			$servicesId = Service::pluck('id')->toArray();
			$package->services()->sync($servicesId);

			DB::commit();

 			return response()->json(['status'=>true, 'package_id'=>intval($package->id), 'message'=>'Successfully a Package has been added']);
 		}catch(Exception $e){
			DB::rollback();
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function update($request,$package)
 	{
		DB::beginTransaction();

 		try
 		{   
 			$validator = Validator::make($request->all(), [
 				'title' => 'required|string|max:50|unique:packages,title,' . $package->id,
 				'status' => 'required|in:Active,Inactive',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was invalid', 'data'=>$validator->errors()],422);  
            }

 			$package->category_id = $request->category_id;
 			$package->title = $request->title;
 			$package->price = $request->price;
 			$package->stake_duration = $request->stake_duration;
 			$package->interest_rate = $request->interest_rate;
 			$package->status = $request->status;
 			$package->update();

			 $servicesId = Service::pluck('id')->toArray();
			 $package->services()->sync($servicesId);

			 DB::commit();

 			return response()->json(['status'=>true, 'package_id'=>intval($package->id), 'message'=>"Successfully the Package has been updated"]);
 		}catch(Exception $e){

			DB::rollback();

 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function delete($package)
 	{
		DB::beginTransaction();
 		try
 		{
			$package->services()->detach();
 			$package->delete();
			 DB::commit();
 			return response()->json(['status'=>true, 'message'=>"Successfully the Package has been deleted"]);
 		}catch(Exception $e){
			DB::rollback();
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function statusUpdate($request)
 	{
 		try
 		{
 			$package = $this->fetch($request)->findorfail($request->package_id);
 			$package->status = $request->status;
 			$package->update();
 			return response()->json(['status'=>true, 'message'=>"Successfully the Package's status has been updated"]);
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}
 }