<?php namespace App;

use Illuminate\Database;

class User extends \Illuminate\Database\Eloquent\Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

    public function levels()
    {
        return $this->belongsToMany('App\Level', 'user_levels','user_id', 'level_id')->withPivot('created_at');
    }

    public function actions()
    {
        return $this->belongsToMany('App\Action', 'user_actions','user_id', 'action_id')
            ->withPivot('action_x','action_y','points','created_at','price','offer_id');
    }

    public function offers()
    {
        return $this->belongsToMany('App\Offer', 'user_actions','user_id', 'offer_id')
            ->withPivot('points','created_at','price','action_id');
    }

    public function offers_saved()
    {
        return $this->offers()->wherePivot('action_id','=',1)->get();
    }

    public function offers_shared()
    {
        return $this->offers()->wherePivot('action_id','=',2)->get();
    }

    public function offers_bought()
    {
        return $this->offers()->wherePivot('action_id','=',3)->get();
    }
}
