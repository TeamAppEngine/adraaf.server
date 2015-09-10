<?php namespace App;

use Illuminate\Database;

class Store extends \Illuminate\Database\Eloquent\Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'stores';

    public function offers()
    {
        return $this->hasMany('App\Offer', 'store_id');
    }

    public function customers()
    {
        $users = [];
        $offers = $this->offers;
        foreach($offers as $offer){
            $users[] = $offer->customers;
        }
        return $users;
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
