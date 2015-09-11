<?php namespace App;

use Illuminate\Database;

class Offer extends \Illuminate\Database\Eloquent\Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'offers';

    public function store()
    {
        return $this->belongsTo('\App\Store');
    }

    public function actions()
    {
        return $this->belongsToMany('App\Action', 'user_actions','offer_id', 'action_id')
            ->withPivot('points','created_at','price','user_id');
    }

    public function customersSaved()
    {
        $user = [];
        $actions = $this->actions()->where('id','=',1)->get();
        foreach($actions as $action){
            $user[] = $action->users;
        }
        return $user;
    }

    public function customersShared()
    {
        $user = [];
        $actions = $this->actions()->where('id','=',2)->get();
        foreach($actions as $action){
            $user[] = $action->users;
        }
        return $user;
    }

    public function customersBought()
    {
        $user = [];
        $actions = $this->actions()->where('id','=',3)->get();
        foreach($actions as $action){
            $user[] = $action->users;
        }
        return $user;
    }
}
