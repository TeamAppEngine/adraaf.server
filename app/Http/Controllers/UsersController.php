<?php

namespace App\Http\Controllers;

use Illuminate\Cache\Repository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Libraries;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
//use Rhumsaa\Uuid;
use App\User;
use App\Offer;
use Repositories\UserRepository;
use Repositories\OfferRepository;

class UsersController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    //TODO: must write tests
    public function store(Request $request)
    {
        //get the email and password from the input
        $email = "";
        $password = "";
        if ($request->get('email') && $request->get('password')) {

            $password = $request->get('password');
            if (Libraries\InputValidator::isEmailValid($request->get('email'))) {
                $email = $request->get('email');
            } else {
                \App::abort(400, 'The contract of the api was not met');
            }
        } else
            \App::abort(400, 'The contract of the api was not met');


        //get the user based on the email
        $userRepo = new UserRepository(new User());
        $user = $userRepo->getUserBasedOnEmail($email)->toArray();

        //fill the information of the user
        //if the user didn't exist
        $userInfo = [];

        if ($user == []) {
            $userInfo = [
                "email" => $email,
                "password" => sha1($password),
                "uuid" => \Rhumsaa\Uuid\Uuid::uuid4()->toString()
                //date("Y-m-d H:i:s")
            ];
        } else {
            \App::abort(409, 'The email is already in use');
        }

        //update the information of the user
        $user = $userRepo->updateUserInfo($userInfo);
        $userRepo->setUserLevel(1);
        $userRepo->logSignUp();

        //send the results back to the user
        return json_encode([
            "points" => 0,
            "level" => 1,
            "user_id" => $user->uuid
        ]);
    }

    /**
     * Get the session for a user
     *
     * @param Request $request the request sent to the user
     * @return Response         the user information
     */
    public function getImage(User $user)
    {

        if ($user->toArray() == [])
            \App::abort(404, 'The API doesn\'t exist');
        $imageUrl = "";
        $imageIndex = Libraries\ImageHelper::getTheCurrentImageIndex($user);
        if ($imageIndex != -1) //the user has an image
        {
            $filePath = storage_path() . "\app\avatars\\" . $user->uuid . "$imageIndex.jpg";

            return \Response::download($filePath, $user->first_name . ".jpg", [
                'Content-Type' => 'text/jpeg',
            ]);
        }
        \App::abort(404, 'The user doesn\'t have a valid image');
    }

    /**
     * Get the image of the user
     *
     * @param  Request $request the username and password of the user
     * @return Response             the image download
     */
    public function getSession(Request $request)
    {

        //get the email and password from the input
        $email = "";
        $password = "";
        if ($request->get('email') && $request->get('password')) {

            $password = $request->get('password');
            if (Libraries\InputValidator::isEmailValid($request->get('email'))) {
                $email = $request->get('email');
            } else {
                \App::abort(400, 'The contract of the api was not met');
            }
        } else
            \App::abort(400, 'The contract of the api was not met');


        //get the user based on the email
        $userRepo = new UserRepository(new User());
        $user = $userRepo->getUserBasedOnEmail($email);

        //fill the information of the user
        //if the user didn't exist
        $userInfo = [];

        if (!isset($user->password)) {
            \App::abort(404, 'The user doesn\'t exist in the database');
        } else {
            if ($user->password != sha1($password)) {
                \App::abort(404, 'The user doesn\'t exist in the database');
            }

            //send the results back to the user
            return json_encode([
                "points" => $userRepo->getUserPoints(),
                "level" => $userRepo->getUserLevel()->id,
                "user_id" => $user->uuid
            ]);


        }

        //send the results back to the user
        return json_encode($userInfo);
    }

    /**
     * Get the image of the user
     *
     * @param  Request $request the username and password of the user
     * @param $user \App\User
     * @return Response             the image download
     */
    public function getOffers(Request $request, User $user)
    {

        if ($user->toArray() == [])
            \App::abort(404, 'The API doesn\'t exist');


        //get the x and y from the input
        $x = "";
        $y = "";

        if ($request->get('x') && $request->get('y')) {

            $x = $request->get('x');
            $y = $request->get('y');
        } else {
            \App::abort(400, 'The contract of the api was not met');
        }

        $offerRepo = new OfferRepository(new Offer());
        $userRepo = new UserRepository($user);
        $userRepo->logDrag($x,$y);

        return json_encode([
            "offers" => $offerRepo->getOffers($x, $y, $user),
            "points" => $userRepo->getUserPoints(),
            "level" => $userRepo->getUserLevel()->id
        ]);
    }

    /**
     * Get the offers
     *
     * @param  Request $request the username and password of the user
     * @return Response             the image download
     */
    public function getOffersAnonymously(Request $request)
    {
        //get the x and y from the input
        $x = "";
        $y = "";

        if ($request->get('x') && $request->get('y')) {

            $x = $request->get('x');
            $y = $request->get('y');
        } else {
            \App::abort(400, 'The contract of the api was not met');
        }

        $offerRepo = new OfferRepository(new Offer());

        return json_encode([
            "offers" => $offerRepo->getOffers($x, $y, null),
            "points" => 0,
            "level" => 0
        ]);
    }
}
