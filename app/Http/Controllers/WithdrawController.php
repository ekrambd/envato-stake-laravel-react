<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Repositories\Withdraw\WithdrawInterface;

class WithdrawController extends Controller
{
    protected $withdraw;

    public function __construct(WithdrawInterface $withdraw)
    {
        $this->withdraw = $withdraw;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $withdraws = $this->withdraw->fetch($request)->latest()->paginate(10);
        return $withdraws;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = $this->withdraw->store($request);
        return $store;
    }

    /**
     * Display the specified resource.
     */
    public function show(Withdraw $withdraw)
    {
        return response()->json(['status'=>true, 'data'=>$withdraw]);
    }
}
