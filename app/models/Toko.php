<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Toko extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tokos';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	
   public function scopeSales($query)
    {
    	return $query->where('sales.id','=',$_GET['selected_sales']);
    }

    public function scopeToko($query)
    {
    	return $query->where('tokos.id','=',$_GET['selected_toko']);
    }

    public function scopeArea($query)
    {
    	return $query->where('sales.area_id','=',$_GET['selected_area']);
    }

    public function scopePocket($query)
    {
    	return $query->where('tokos.pocket_id','=',$_GET['selected_pocket']);
    }

}