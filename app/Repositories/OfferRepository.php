<?php namespace Repositories;

use App\Offer;
use App\User;

class OfferRepository {

    private $OfferModel = null;

    public function __construct(Offer $offer){
        $this->OfferModel = $offer;
    }

    /**
     * @param $id           integer, the id of the offer
     * @return              Offer, the information of the offer based on id
     */
    public function getOfferBasedOnId($id){
        try{
            $this->OfferModel = $this->OfferModel->where('id',$id)->first();
            if($this->OfferModel == null)
                $this->OfferModel = new Offer();
            return $this->OfferModel;
        }
        catch(\Exception $e){
            $this->OfferModel = new Offer();
            return $this->OfferModel;
        }
    }

    /**
     * Updates the information of the offer
     *
     * @param $offerInfo     array, the information of the offer that wants to be updated
     * @return mixed
     */
    public function updateOfferInfo(array $offerInfo){

        foreach($offerInfo as $key => $value)
        {
            $this->OfferModel->{$key} = $value;
        }

        $this->OfferModel->save();
        return $this->OfferModel;
    }

    /**
     * @param $x
     * @param $y
     * @param User $user
     * @return mixed
     */
    public function getOffers($x, $y, User $user=null)
    {
        $offers = Offer::with('store')->get();
        $resultOffers = [];
        $percentage = 0.05;
        if($user != null){
            $userRepo = new UserRepository($user);
            $percentage = $userRepo->getPercentage();
        }

        for($radius = 1 ; $radius < 4 && count($resultOffers) < 5 ; $radius++) {
            foreach ($offers as $offer) {
                $sw = 0;
                foreach($resultOffers as $resultOffer){
                    if($offer->id == $resultOffer["id"]) {
                        $sw = 1;
                        break;
                    }
                }
                if($sw == 0) {
                    if ($this->distance($offer->store->x, $offer->store->y, $x, $y, 'K') < $radius) {
                        $tempOffer = [];
                        $tempOffer["x"] = $offer->store->x;
                        $tempOffer["y"] = $offer->store->y;
                        $tempOffer["category"] = $offer->store->category->id;
                        $tempOffer["expire"] = strtotime($offer->end_date);
                        $tempOffer["percent"] = $percentage * ($offer->maximum_percentage - 1);
                        $tempOffer["title"] = $offer->store->title;
                        $tempOffer["description"] = $offer->description;
                        $tempOffer["address"] = $offer->store->address;
                        $tempOffer["img"] = "http://178.238.226.60/api/stores/" . $offer->store->id . "/image";
                        $tempOffer["id"] = $offer->store->id;
                        $resultOffers[] = $tempOffer;
                    }
                }
            }
        }

        return $resultOffers;
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}