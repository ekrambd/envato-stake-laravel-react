<?php
 namespace App\Repositories\Purchase;
 use App\Models\Purchase;
 use Validator;

 class PurchaseRepository implements PurchaseInterface
 {
 	public function fetch($request)
 	{
 		try
 		{
 			$query = Purchase::query();
 			if($request->has('title'))
 			{   
 				$search = $request->title;
 				$query->where('purchases.title', 'LIKE', "%$search%");
 			}
 			$purchases = $query->select('*');
 			return $purchases;
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function store($request)
 	{
 		try
 		{   

 			$validator = Validator::make($request->all(), [
 				'package_id' => 'required',
 				'wallet_address' => 'required|string|max:191',
 				'price' => 'required',
 				'duration' => 'required',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was invalid', 'data'=>$validator->errors()],422);  
            }
		
			$purchase = new Purchase();
			$purchase->user_id = user()->id;
			// $purchase->user_id = 1;
			$purchase->package_id =  $request->package_id;
			$purchase->wallet_address =  $request->wallet_address;
			$purchase->price =  $request->price;
			$purchase->duration =  $request->duration;
			$purchase->transaction_hash =  "Test";
			$purchase->date =  date('Y-m-d');
			$purchase->time = date("h:m:s");
			$purchase->status =  "Active";
			$purchase->save();
 			
		
 			return response()->json(['status'=>true, 'purchase_id'=>intval($purchase->id), 'message'=>'Successfully a Purchase has been added']);
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 
 }