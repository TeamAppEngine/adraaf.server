<?php namespace Repositories;

use App\User;

class UserRepository {

    private $UserModel = null;

    public function __construct(User $user){
        $this->UserModel = $user;
    }

    /**
     * @param $uuid         string the uuid of the user
     * @return              User, the information of the user based on uuid
     */
    public function getUserBasedOnUuid($uuid){
        try {
            $this->UserModel = $this->UserModel->where('uuid', $uuid)->first();
            if($this->UserModel == null)
                $this->UserModel = new User();
            return $this->UserModel;
        }
        catch(\Exception $e){
            $this->UserModel = new User();
            return $this->UserModel;
        }
    }

    /**
     * @param $id           integer, the id of the user
     * @return              User, the information of the user based on id
     */
    public function getUserBasedOnId($id){
        try{
            $this->UserModel = $this->UserModel->where('id',$id)->first();
            if($this->UserModel == null)
                $this->UserModel = new User();
            return $this->UserModel;
        }
        catch(\Exception $e){
            $this->UserModel = new User();
            return $this->UserModel;
        }
    }

    /**
     * @param $email        string, the email of the user
     * @return              User, the information of the user based on email
     */
    public function getUserBasedOnEmail($email){
        try {
            $this->UserModel = $this->UserModel->where('email', $email)->first();
            if($this->UserModel == null)
                $this->UserModel = new User();
            return $this->UserModel;
        }
        catch(\Exception $e){
            $this->UserModel = new User();
            return $this->UserModel;
        }
    }

    /**
     * Updates the information of the user
     *
     * @param $userInfo     array, the information of the user that wants to be updated
     * @return mixed
     */
    public function updateUserInfo(array $userInfo){

        foreach($userInfo as $key => $value)
        {
            $this->UserModel->{$key} = $value;
        }

        $this->UserModel->save();
        return $this->UserModel;
    }

    /**
     * @param $int integer the level that the user wants to be in
     */
    public function setUserLevel($int)
    {
        $this->UserModel->levels()->attach($int);
    }

    /**
     *
     */
    public function getUserLevel()
    {
        $levels = $this->UserModel->levels;
        return $levels[count($levels)-1];
    }

    /**
     *
     */
    public function getPercentage()
    {
        $level = $this->getUserLevel();
        return ceil(0.05*$level->id);
    }

    /**
     *
     */
    public function getUserPoints()
    {
        $actions = $this->UserModel->actions;
        return $actions->sum('point');
    }

    /**
     *
     */
    public function logDrag($x,$y)
    {
        $action = \App\Action::where('title','=','drag_to_search')->get()->first();
        $this->UserModel->actions()->attach($action->id, [
            'points' => $action->point,
            'action_x' => $x,
            'action_y' => $y,
        ]);
    }

    /**
     *
     */
    public function logSignUp()
    {
        $action = \App\Action::where('title','=','sign_up')->get()->first();
        $this->UserModel->actions()->attach($action->id, [
            'points' => $action->point
        ]);
    }

    /**
     * @param \App\Offer $offer
     */
    public function logShare(\App\Offer $offer)
    {
        $action = \App\Action::where('title','=','share_offer')->get()->first();
        $this->UserModel->actions()->attach($action->id, [
            'points' => $action->point,
            'offer_id' => $offer->id
        ]);
    }

    /**
     * @param \App\Offer $offer
     */
    public function logSave(\App\Offer $offer)
    {
        $action = \App\Action::where('title','=','save_offer')->get()->first();
        $this->UserModel->actions()->attach($action->id, [
            'points' => $action->point,
            'offer_id' => $offer->id
        ]);
    }

    /**
     * @param \App\Offer $offer
     */
    public function logBuy(\App\Offer $offer)
    {
        $action = \App\Action::where('title','=','buy_offer')->get()->first();
        $this->UserModel->actions()->attach($action->id, [
            'points' => $action->point,
            'offer_id' => $offer->id
        ]);
    }
}