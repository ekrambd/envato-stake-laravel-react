<?php
 namespace App\Repositories\Purchase;

 interface PurchaseInterface
 {
 	public function fetch($request);
 	public function store($request);
 	
 }