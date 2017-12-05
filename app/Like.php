<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model {
	protected $fillable = [
		'user_to',
		'user_who',
	];

	protected $table = 'likeable';

}
