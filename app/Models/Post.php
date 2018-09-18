<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Post extends Moloquent
{
//	protected $appends = ['id'];
	protected $dates = [
		'created_at',
		'updated_at',
	];
	protected $casts = [
		'created_at' => 'datetime:l jS F Y',
		'updated_at' => 'datetime:l jS F Y',
	];
	protected $dateFormat = 'Y-m-d';
	protected $collection = 'posts';
    protected $connection = "mongodb";
    protected $fillable = [ 'title', 'content'];
}
