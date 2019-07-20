<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\SocialProvider;
use Auth;
use Socialite;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/tournament';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $user_data)
    {
    	$avatar = "https://avatars.dicebear.com/v2/jdenticon/".md5($user_data['email']).".svg";
    	// $avatar = "https://www.gravatar.com/avatar/".md5($user_data['email'])."?d=wavatar";

        $user = User::create([
            'name' => $user_data['name'],
            'email' => $user_data['email'],
            'password' => bcrypt($user_data['password']),
            'avatar' => $avatar
        ]);

        return $user;
    }


    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
 
    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {

        $user = Socialite::driver($provider)->user();
        // create or find the user
        $authUser = $this->findOrCreateUser($user, $provider);
        // log the user in
        Auth::login($authUser, true);
        // redirect to variable at top
        return redirect()->action('TournamentController@getActiveTour');

    }
 
    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateUser($user, $provider)
    {

        $avatar = "https://avatars.dicebear.com/v2/jdenticon/".md5($user->email).".svg";
        //find user 
        $sp = SocialProvider::where('provider_id', $user->id)->where('provider', $provider)->first();
        
        //if found return the user, if not create it and return it
        if($sp) {
            $u = User::where('id', $sp->user_id)->first();
            $u->avatar = $avatar;
            $u->save();
            return $u;
        }

        $user_existing = User::where('email', $user->email)->first();
        if($user_existing){
            // if email exists already, add new social provider

            $sp_new = SocialProvider::create([
                'user_id' => $user_existing->id,
                'provider' => $provider,
                'provider_id' => $user->id,
                'avatar'   => $avatar,
            ]);

            $user_existing->avatar = $avatar;
            $user_existing->save();
            return $user_existing;

        }else{
            // if email doesnt exist yet, create new user and social provider
            $user_new = User::create([
                'name'     => $user->name,
                'email'    => $user->email,  
            ]);

            $sp_new = SocialProvider::create([
                'user_id' => $user_new->id,
                'provider' => $provider,
                'provider_id' => $user->id,
                'avatar'   => $avatar,
            ]);

            $user_new->avatar = $avatar;
            $user_new->save();
            return $user_new;
        }

    }




    /* Log out the user */
    public function getSignOut() {

        Auth::logout();
        return view('welcome');
    }


}
