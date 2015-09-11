<?php namespace Repositories;

use App\Store;
use App\User;

class StoreRepository {

    private $StoreModel = null;

    public function __construct(Store $store){
        $this->StoreModel = $store;
    }

    /**
     * @param $id           integer, the id of the store
     * @return              Store, the information of the store based on id
     */
    public function getStoreBasedOnId($id){
        try{
            $this->StoreModel = $this->StoreModel->where('id',$id)->first();
            if($this->StoreModel == null)
                $this->StoreModel = new Store();
            return $this->StoreModel;
        }
        catch(\Exception $e){
            $this->StoreModel = new Store();
            return $this->StoreModel;
        }
    }
}