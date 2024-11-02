<?php
 namespace App\Repositories\Category;
 use App\Models\Category;
 use Validator;

 class CategoryRepository implements CategoryInterface
 {
 	public function fetch($request)
 	{
 		try
 		{
 			$query = Category::query(); 
 			if($request->has('category_name'))
 			{   
 				$search = $request->category_name;
 				$query->where('categories.category_name', 'LIKE', "%$search%");
 			}
 			$categories = $query->select('*');
 			return $categories;
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function store($request)
 	{
 		try
 		{   

 			$validator = Validator::make($request->all(), [
 				'category_name' => 'required|string|max:50|unique:categories',
 				'status' => 'required|in:Active,Inactive',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was invalid', 'data'=>$validator->errors()],422);  
            }
 			$category = Category::create([
 				'user_id' => user()->id,
 				'category_name' => $request->category_name,
 				'status' => $request->status
 			]);

 			return response()->json(['status'=>true, 'category_id'=>intval($category->id), 'message'=>'Successfully a category has been added']);

 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function update($request,$category)
 	{
 		try
 		{   
 			$validator = Validator::make($request->all(), [
 				'category_name' => 'required|string|max:50|unique:categories,category_name,' . $category->id,
 				'status' => 'required|in:Active,Inactive',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false, 'message'=>'The given data was invalid', 'data'=>$validator->errors()],422);  
            }
            
 			$category->category_name = $request->category_name;
 			$category->status = $request->status;
 			$category->update();
 			return response()->json(['status'=>true, 'category_id'=>intval($category->id), 'message'=>'Successfully the category has been updated']);
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function delete($category)
 	{
 		try
 		{
 			$category->delete();
 			return response()->json(['status'=>true, 'message'=>"Successfully the category has been deleted"]);
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}

 	public function statusUpdate($request)
 	{
 		try
 		{
 			$category = $this->fetch($request)->findorfail($request->category_id);
 			$category->status = $request->status;
 			$category->update();
 			return response()->json(['status'=>true, 'message'=>"Successfully the category's status has been updated"]);
 		}catch(Exception $e){
 			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
 		}
 	}
 }