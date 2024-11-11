<?php
 namespace App\Repositories\Withdraw;

 interface WithdrawInterface
 {
 	public function fetch($request);
 	public function store($request);
 	
 }