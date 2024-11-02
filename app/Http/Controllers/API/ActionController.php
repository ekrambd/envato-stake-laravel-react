<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\category\CategoryInterface;
use App\Repositories\service\ServiceInterface;
class ActionController extends Controller
{
    protected $category;
    protected $service;
    public function __construct(
    	CategoryInterface $category,
    	ServiceInterface $service
    )
    {
    	$this->category = $category;
    	$this->service = $service;
    }

    public function categoryStatusUpdate(Request $request)
    {
    	$statusUpdate = $this->category->statusUpdate($request);
    	return $statusUpdate; 
    }

    public function serviceStatusUpdate(Request $request)
    {
    	$statusUpdate = $this->service->statusUpdate($request);
    	return $statusUpdate;
    } 
}
