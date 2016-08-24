<?php

namespace App\Http\AuthTraits\Social;

use App\Exceptions\EmailNotProvidedException;
use Redirect;
use Socialite;


trait ManagesSocial
{

    // the traits contain the methods needed for the handleProviderCallback

    use FindsOrCreatesUsers,
        RoutesSocialUser,
        SetsAuthUser,
        SyncsSocialUsers,
        VerifiesSocialUsers;


    public function handleProviderCallback($provider)
    {
        $socialUser = $this->getUserFromSocialite($provider);

        $facebookEmail = $socialUser->getEmail();

        if ($this->socialUserHasNoEmail($facebookEmail)) {

            throw new EmailNotProvidedException;

        }

        if ($this->socialUserAlreadyLoggedIn()) {

            $this->checkIfAccountSyncedOrSync($socialUser);

        }

        // set authUser from socialUser

        $authUser = $this->setAuthUser($socialUser);

        $this->loginAuthUser($authUser);

        $this->logoutIfUserNotActiveStatus();

        return $this->redirectUser();

    }

}