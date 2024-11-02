<?php
 namespace App\Repositories\Service;
 use App\Models\Service;
 use Validator;

 class ServiceRepository implements ServiceInterface
 {
 	public function fetch($request)
 	{
 		try
 		{
 			$query = Service::query();
 			if($request->has('title'))
 			{   
 				$search = $request->title;
 				$query->where('services.title', 'LIKE', "%$search%");
 			}
 			$services = $query->select('*');
 			return $services;
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function store($request)
 	{
 		try
 		{   

 			$validator = Validator::make($request->all(), [
 				'title' => 'required|string|max:50|unique:services',
 				'status' => 'required|in:Active,Inactive',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was invalid', 'data'=>$validator->errors()],422);  
            }

 			$service = Service::create([
 				'user_id' => user()->id,
 				'title' => $request->title,
 				'status' => $request->status,
 			]);

 			return response()->json(['status'=>true, 'service_id'=>intval($service->id), 'message'=>'Successfully a service has been added']);
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function update($request,$service)
 	{
 		try
 		{   
 			$validator = Validator::make($request->all(), [
 				'title' => 'required|string|max:50|unique:services,title,' . $service->id,
 				'status' => 'required|in:Active,Inactive',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was invalid', 'data'=>$validator->errors()],422);  
            }

 			$service->title = $request->title;
 			$service->status = $request->status;
 			$service->update();
 			return response()->json(['status'=>true, 'service_id'=>intval($service->id), 'message'=>"Successfully the service has been updated"]);
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function delete($service)
 	{
 		try
 		{
 			$service->delete();
 			return response()->json(['status'=>true, 'message'=>"Successfully the servie has been deleted"]);
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function statusUpdate($request)
 	{
 		try
 		{
 			$service = $this->fetch($request)->findorfail($request->service_id);
 			$service->status = $request->status;
 			$service->update();
 			return response()->json(['status'=>true, 'message'=>"Successfully the service's status has been updated"]);
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}
 }