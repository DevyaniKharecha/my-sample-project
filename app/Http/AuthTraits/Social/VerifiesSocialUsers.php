<?php

namespace App\Http\AuthTraits\Social;

use Illuminate\Support\Facades\Auth;
use App\User;

trait VerifiesSocialUsers
{

    private function authUserEmailMatches($facebookUser)
    {

        return $facebookUser->email == Auth::user()->email;

    }

    /**
     * @param $facebookUser
     * @return mixed
     */

    private function idAlreadyExists($facebookUser)
    {

        return User::where('facebook_id', '=', $facebookUser->id)->exists();

    }


    /**
     * @return mixed
     */

    private function socialUserAlreadyLoggedIn()
    {

        return Auth::check();

    }

    private function socialUserHasNoEmail($socialUserEmail)
    {

        return $socialUserEmail == null;

    }


    /**
     * @param $facebookUser
     * @return bool
     */

    private function verfiyUserIds($facebookUser)
    {

        return (Auth::user()->facebook_id == $facebookUser->id) ? true : false;

    }


}