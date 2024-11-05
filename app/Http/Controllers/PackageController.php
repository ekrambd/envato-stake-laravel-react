<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Repositories\Package\PackageInterface;

class PackageController extends Controller
{
    protected $package;

    public function __construct(PackageInterface $package)
    {
        $this->package = $package;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $packages = $this->package->fetch($request)->latest()->paginate(10);
        return $packages;
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
        $store = $this->package->store($request);
        return $store;
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        return response()->json(['status'=>true, 'data'=>$package]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $update = $this->package->update($request,$package);
        return $update;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $delete = $this->package->delete($package);
        return $delete;
    }
}
