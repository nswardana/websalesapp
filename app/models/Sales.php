<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Sales extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sales';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	public function scopeSales($query)
    {
    	return $query->where('sales.id','=',$_GET['selected_sales']);
    }

    
    public function scopeArea($query)
    {
    	return $query->where('sales.area_id','=',$_GET['selected_area']);
    }


}