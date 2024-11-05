<?php
 namespace App\Repositories\Package;

 interface PackageInterface
 {
 	public function fetch($request);
 	public function store($request);
 	public function update($request,$package);
 	public function delete($package);
 	public function statusUpdate($request);
 }