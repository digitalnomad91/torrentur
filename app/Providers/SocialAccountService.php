<?php

namespace App\Providers;
use App\SocialAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Http\Controllers\FileController;


class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'username' => $providerUser->getName(),
                    'password' => md5(rand(1,10000)),
                ]);
                /* Grab avatar image file from provider & set as new user avatar id */
                $file = FileController::uploadFromURL($providerUser->getAvatar());
                $user->avatar_file_id = $file->id;
                $user->save();
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}