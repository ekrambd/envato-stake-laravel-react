<?php
 
 function user()
 {
 	$user = auth()->user();
 	return $user;
 }