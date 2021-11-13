<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Http\Controllers\FileController;
use App\Providers\SocialAccountService;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the $Provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($Provider)
    {
        return Socialite::driver($Provider)->redirect();
    }

    /**
     * Obtain the user information from $Provider.
     *
     * @return Response
     */
    public function handleProviderCallback(SocialAccountService $service, $Provider)
    {
        $user = Socialite::driver($Provider)->user();
        // OAuth Two Providers
        $token = $user->token;
        $refreshToken = $user->refreshToken; // not always provided
        $expiresIn = $user->expiresIn;

        // OAuth One Providers
        //$token = $user->token;
        //$tokenSecret = $user->tokenSecret;

        // All Providers
        echo $user->getId();
        echo "<br>";
        echo $user->getNickname();
        echo "<br>";
        echo $user->getName();
        echo "<br>";
        echo $user->getEmail();
        echo "<br>";
        echo $user->getAvatar();

        $user = $service->createOrGetUser($user);
        auth()->login($user);
        return redirect()->to('/home');

        // $user->token;
    }


}
