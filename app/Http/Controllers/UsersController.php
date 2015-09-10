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
use Repositories\SessionRepository;
use Repositories\TopicRepository;
use Repositories\UserRepository;
use Repositories\CountryRepository;

class UsersController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        \App::abort(404, 'function not implemented');
    }

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

        //send the results back to the user
        return json_encode([
            "points" => 0,
            "level" =>1,
            "user_id" => $user->uuid
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    //TODO: write unit tests
    public function show(User $user, User $partner)
    {

        if ($user->toArray() == [] || $partner->toArray() == [])
            \App::abort(404, 'The API doesn\'t exist');
        $imageUrl = "";
        $imageIndex = Libraries\ImageHelper::getTheCurrentImageIndex($partner);
        if ($imageIndex != -1) //the user has an image
        {
            $imageUrl = \Request::url() . "/image";
        }

        $sessionRepo = new SessionRepository(new \App\Session());
        $session = $sessionRepo->getSessionDetails($user, $partner);
        $topicRepo = new TopicRepository(new \App\Topic());
        $topic = $topicRepo->getTopicBasedOnId($session->topic_id);
        $userRepo = new UserRepository(new \App\User());
        $tempTopic = [];
        $tempTopic['id'] = $topic->id;
        $tempTopic['text'] = $topic->text;
        $tempTopic['extra_question'] = $topic->extraQuestions()->FirstOrFail()->text;
        $prompts = $topic->prompts;
        $promptArray = [];
        foreach($prompts as $prompt)
        {
            $tempPrompt['id'] = $prompt->id;
            $tempPrompt['text'] = $prompt->text;
            $promptArray[] = $tempPrompt;
        }
        $tempTopic['prompts'] = $promptArray;

        $result = [
            "partner" => [
                "email" => $partner->email,
                "first_name" => $partner->first_name,
                "last_name" => $partner->last_name,
                "birth_date" => $partner->date_of_birth,
                "country_iso" => $partner->country->iso_code,
                "profile_image" => $imageUrl,
                "gender" => $partner->gender
            ],
            "role" => $userRepo->getUserRoleBasedOnEmail($partner)->role,
            "topic" => $tempTopic
        ];

        return json_encode($result);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  \App\User the information of the user
     * @return Response
     */
    public function changePresence(Request $request, User $user)
    {
        if ($user->toArray() == [])
            \App::abort(404, 'The API doesn\'t exist');

        if ($request->get('presence')){
            $presenceId = $request->get('presence');
            $userRepo = new UserRepository($user);
            $userRepo->updateUserPresence($presenceId);
        } else {
            \App::abort(400, 'The contract of the api was not met');
        }

        return json_encode([]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  \App\User the information of the user
     * @return Response
     */
    //TODO: must write tests
    public function update(Request $request, User $user)
    {

        if ($user->toArray() == [])
            \App::abort(404, 'The API doesn\'t exist');

        if ($request->get('first_name') &&
            $request->get('last_name') &&
            $request->get('birth_date') &&
            $request->get('gender') &&
            $request->get('country_iso')
        ) {
            Libraries\ImageHelper::saveTheProfileImage($request, $user);

            $countryRepo = new CountryRepository(new \App\Country);
            $country = $countryRepo->getCountryBaseOnISO($request->get('country_iso'));
            $userInfo = [
                "first_name" => $request->get('first_name'),
                "last_name" => $request->get('last_name'),
                "country_id" => $country->id,
                "date_of_birth" => $request->get('birth_date'),
                "gender" => $request->get('gender') == 'male' ? 1 : 0,
            ];

            $userRepo = new UserRepository($user);
            $userRepo->updateUserInfo($userInfo);
        } else {
            \App::abort(400, 'The contract of the api was not met');
        }

        return json_encode([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
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


}
