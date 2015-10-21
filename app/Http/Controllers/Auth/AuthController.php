<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Session, Input, Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Laravel\Socialite\Contracts\Factory as Socialite;
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
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Socialite $socialite)
    {
        $this->socialite = $socialite;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    // public function getSocialAuth($provider=null)
    //    {
    //        if(!config("services.$provider")) abort('404'); //just to handle providers that doesn't exist

    //        return $this->socialite->with($provider)->redirect();
    //    }

    public function getFacebookAuth(){
        if(!config("services.facebook")) abort('404'); //just to handle providers that doesn't exist

           return $this->socialite->with('facebook')->redirect();
    }
    public function getFacebookAuthCallback(){
        $provider = 'facebook';
        if($fbuser = $this->socialite->with($provider)->user()){
            // $u = User::where('email', '=', $user->email)->firstOrFail();
            if($u = User::where('email', '=', $fbuser->email)->first()){
                if($u->facebook_token == $fbuser->token){
                    Auth::login($u);
                    return redirect('/dashboard');
                } else {
                    return redirect('/login');
                }
            } else {
                $fbu = [
                    "first_name" => $fbuser->user['first_name'],
                    "last_name" => $fbuser->user['last_name'],
                    "email" => $fbuser->email,
                    "id" => $fbuser->id,
                    "token" => $fbuser->token,
                ];
                return redirect('/facebook/register')->with('fbuser', $fbu);
            }
        } else {
            return redirect('/oops');
        } 
    }

    // public function getFacebookLogin(){

    // }

    public function getFacebookRegister(){
        if(Session::has('fbuser') || Input::get('facebook_id')){
            // return dd(Session::get('fbuser'));
            session(['fbuser' => Session::get('fbuser') ]);
            return view('transfer.fbregister')->with('fbuser', Session::get('fbuser'));
        } else {
            // $request->session()->flash('message', 'Couldn\'t authenticate with Facebook');
            return redirect('/register');
        }
        return view('transfer.fbregister');
    }

    public function postFacebookRegister(){
        // return Input::all();
        // if(!isset(Input::get('email')) || !Input::get('password')){
        //     return redirect('facebook/register')->withInput();
        // }

        $rules = [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ];

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {

        // get the error messages from the validator
        $messages = $validator->messages();

        // redirect our user back to the form with the errors from the validator
        $fbuser = [
            'email' => Input::get('email'), 
            'id' => Input::get('facebook_id'),
            'token' => Input::get('facebook_token'),
            'first_name' => Input::get('first_name'),
            'last_name' => Input::get('last_name'),
        ];
        return redirect('facebook/register')
            ->withErrors($validator)->with('fbuser', $fbuser);

        } else {
            $u = new User;
            $u->email = Input::get('email');
            $u->first_name = Input::get('first_name');
            $u->last_name = Input::get('last_name');
            $u->facebook_id = Input::get('facebook_id');
            $u->facebook_token = Input::get('facebook_token');
            $u->save();
            Auth::login($u);
            return redirect('/dashboard');
        }
    }
       public function getSocialAuthCallback($provider=null)
       {
          if($user = $this->socialite->with($provider)->user()){
            // return $user->user['first_name'];
            // dd($user);
            // return $user->email;
            $u = App\User::where('email', '=', $user->email)->firstOrFail();
            
            if($u){

                if(!$u->first_name){
                    $u->first_name = $user->user['first_name'];
                }

                if(!$u->last_name){
                    $u->last_name = $user->user['last_name'];
                }

                if(!$u->facebook_id){
                    $u->facebook_id = $user->id;
                }

                if(!$u->token){
                    $u->facebook_token = $user->token;
                }
                $u->save();
                return redirect('dashboard');
            } else {
                $u = new User;
                $u->email = $user->email;
                $u->first_name = $user->user['first_name'];
                $u->last_name = $user->user['last_name'];
                $u->facebook_id = $user->id;
                $u->facebook_token = $user->token;
                $u->password = bcrypt($password);
            }
            
            // if($model = App\Flight::where('legs', '>', 100)->firstOrFail();)
          }else{
             return 'something went wrong';
          }
       }
}
