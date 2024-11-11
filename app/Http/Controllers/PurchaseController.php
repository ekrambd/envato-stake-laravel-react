<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Repositories\Purchase\PurchaseInterface;

class PurchaseController extends Controller
{
    protected $purchase;

    public function __construct(PurchaseInterface $purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $purchases = $this->purchase->fetch($request)->latest()->paginate(10);
        return $purchases;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = $this->purchase->store($request);
        return $store;
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return response()->json(['status'=>true, 'data'=>$purchase]);
    }
}
