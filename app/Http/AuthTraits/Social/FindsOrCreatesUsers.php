<?php

namespace App\Http\AuthTraits\Social;

use App\User;
use App\Exceptions\EmailAlreadyInSystemException;
use App\Exceptions\CredentialsDoNotMatchException;

trait FindsOrCreatesUsers
{
    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */

    private function findOrCreateUser($facebookUser)
    {
        // is email already in table?
        // if email is in table, does the facebook id match?
        // if there is a match, return $authUser, if not throw exception

        if ( $authUser = User::where('email', $facebookUser->email)->first()){

            if ( ! $authUser->facebook_id == $facebookUser->id){

                throw new EmailAlreadyInSystemException;
            }

            return $authUser;
        }

        // check to see if existing user already has facebook id

        if ($this->idAlreadyExists($facebookUser)){

            throw new CredentialsDoNotMatchException;

        }
        //create user if not already exists and email does not already exist.

        $password = $this->makePassword();

        return User::create([
            'name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'password' => $password,
            'status_id' => 10,
            'facebook_id' => $facebookUser->id,
            'avatar' => $facebookUser->avatar
        ]);
    }

    /**
     * @return string
     */

    private function makePassword()
    {
        $passwordParts = rand() . str_random(12);
        $password = bcrypt($passwordParts);

        return $password;

    }



}