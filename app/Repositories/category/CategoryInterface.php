<?php
 namespace App\Repositories\Category;

 interface CategoryInterface
 {
 	public function fetch($request);
 	public function store($request);
 	public function update($request,$category);
 	public function delete($category);
 	public function statusUpdate($request);
 }