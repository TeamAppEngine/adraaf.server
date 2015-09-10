<?php namespace App;

use Illuminate\Database;

class Level extends \Illuminate\Database\Eloquent\Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'levels';

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_levels','level_id', 'user_id')->withPivot('created_at');
    }
}
