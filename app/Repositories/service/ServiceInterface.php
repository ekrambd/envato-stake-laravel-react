<?php
 namespace App\Repositories\Service;

 interface ServiceInterface
 {
 	public function fetch($request);
 	public function store($request);
 	public function update($request,$service);
 	public function delete($service);
 	public function statusUpdate($request);
 }