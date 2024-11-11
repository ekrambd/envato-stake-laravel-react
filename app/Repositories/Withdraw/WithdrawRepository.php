<?php
 namespace App\Repositories\Withdraw;
 use App\Models\Withdraw;
 use Validator;

 class WithdrawRepository implements WithdrawInterface
 {
 	public function fetch($request)
 	{
 		try
 		{
 			$query = Withdraw::query();
 			if($request->has('title'))
 			{   
 				$search = $request->title;
 				$query->where('withdraws.title', 'LIKE', "%$search%");
 			}
 			$withdraws = $query->select('*');
 			return $withdraws;
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function store($request)
 	{
 		try
 		{   

 			$validator = Validator::make($request->all(), [
 				'recipient_address' => 'required|string|max:191',
 				'amount' => 'required',
 				
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was invalid', 'data'=>$validator->errors()],422);  
            }
		
			$withdraw = new Withdraw();
			$withdraw->user_id =  user()->id;
			$withdraw->recipient_address =  $request->recipient_address;
			$withdraw->amount =  $request->amount;
			$withdraw->transaction_hash =  "Test";
			$withdraw->date =  date('Y-m-d');
			$withdraw->time = date("h:m:s");
			$withdraw->status =  "Active";
			$withdraw->save();

 		
 			return response()->json(['status'=>true, 'withdraw_id'=>intval($withdraw->id), 'message'=>'Successfully a Withdraw has been added']);
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 
 }