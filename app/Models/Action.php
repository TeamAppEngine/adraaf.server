<?php namespace App;

use Illuminate\Database;

class Action extends \Illuminate\Database\Eloquent\Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'actions';

    public function user()
    {
        return $this->belongsToMany('App\User', 'user_actions','action_id', 'user_id')
            ->withPivot('action_x','action_y','points','created_at','price','offer_id');
    }

    public function offer()
    {
        return $this->belongsToMany('App\Offer', 'user_actions','action_id', 'offer_id')
            ->withPivot('action_x','action_y','points','created_at','price','offer_id');
    }
}
