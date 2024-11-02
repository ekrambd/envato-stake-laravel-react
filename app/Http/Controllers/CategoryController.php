<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\category\CategoryInterface;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $category;
    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {   
        $categories = $this->category->fetch($request)->latest()->paginate(10);
        return $categories;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = $this->category->store($request);
        return $store;
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json(['status'=>true, 'data'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $update = $this->category->update($request,$category);
        return $update;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $delete = $this->category->delete($category);
        return $delete;
    }
}
