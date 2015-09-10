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
    public function getUserPoints()
    {
        $actions = $this->UserModel->actions;
        return $actions->sum('points');
    }
}