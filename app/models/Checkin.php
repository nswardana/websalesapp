<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Checkin extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'checkins';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	
	 public function scopePocket($query)
    {
    	return $query->where('tokos.pocket_id','=',$_GET['selected_pocket']);
    }


	

}
