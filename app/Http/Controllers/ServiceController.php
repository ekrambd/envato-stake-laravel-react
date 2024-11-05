<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Repositories\Service\ServiceInterface;

class ServiceController extends Controller
{
    
    protected $service;

    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $services = $this->service->fetch($request)->latest()->paginate(10);
        return $services;
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
        $store = $this->service->store($request);
        return $store;
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return response()->json(['status'=>true, 'data'=>$service]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $update = $this->service->update($request,$service);
        return $update;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $delete = $this->service->delete($service);
        return $delete;
    }
}
