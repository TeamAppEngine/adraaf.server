<?php namespace App;

use Illuminate\Database;

class Category extends \Illuminate\Database\Eloquent\Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'categories';

    public function stores()
    {
        return $this->hasMany('App\Store');
    }
}
