<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Service\ServiceInterface;
use App\Repositories\Package\PackageInterface;
class ActionController extends Controller
{
    protected $category;
    protected $service;
    protected $package;
    public function __construct(
    	CategoryInterface $category,
    	ServiceInterface $service,
    	PackageInterface $package,
    )
    {
    	$this->category = $category;
    	$this->service = $service;
    	$this->package = $package;
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
    public function packageStatusUpdate(Request $request)
    {
    	$statusUpdate = $this->package->statusUpdate($request);
    	return $statusUpdate;
    } 
}
