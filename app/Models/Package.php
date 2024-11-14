<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

	protected $fillable = [
    	'user_id',
        'category_id',
        'title',
        'price',
        'stake_duration',
        'interest_rate',
        'status',
    ];

    public function services()
	{
	    return $this->belongsToMany(Service::class,'package_service','package_id','service_id');
	}

}
