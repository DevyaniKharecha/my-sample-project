<?php

namespace App\Http\AuthTraits\Social;

use App\Exceptions\AlreadySyncedException;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Requests;

trait SyncsSocialUsers
{

    /**
     * @param $facebookUser
     * @return mixed
     */

    private function accountSynced($facebookUser)
    {
        if ($this->authUserEmailMatches($facebookUser)){

            return $this->verfiyUserIds($facebookUser);

        }

        return false;

    }

    private function checkIfAccountSyncedOrSync($facebookUser)
    {
        //if you are logged in and accountSynced is true, you are already synced

        if ($this->accountSynced($facebookUser)){

            throw new AlreadySyncedException;

        } else {

            // check for email match

            if ( ! $this->authUserEmailMatches($facebookUser)) {

                throw new CredentialsDoNotMatchException;

            }

            // if emails match, then sync accounts

            $this->syncUserAccountWithSocialData($facebookUser);

            alert()->success('Confirmed!', 'You are now synced...');

            return $this->redirectUser();

        }

    }

    private function syncUserAccountWithSocialData($facebookUser)
    {

        // lookup user and update user record

        $id = Auth::user()->id;

        $user = User::findOrFail($id);

        $user->update(['facebook_id' => $facebookUser->id,
                       'avatar'      => $facebookUser->avatar]);

    }




}