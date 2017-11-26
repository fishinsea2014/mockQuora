<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Request;
use Hash;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function has_user_name_and_password(){
        $username=Request::get('username');
        $password=Request::get('password');
        // -username and password is null
        if ($username && $password)
            return [$username,$password];
        return false;
    }

    public function signUp(){
        /**Check user inputs, including:**/
        $has_user_name_and_password=$this->has_user_name_and_password();
        if (!$has_user_name_and_password){
            return ['status'=>0,'msg'=>'user name and password can not be null.'];
        };
        $username=$has_user_name_and_password[0];
        $password=$has_user_name_and_password[1];

//         * -user is a valid user
        $user_exists=$this
            ->where('username',$username)
            ->exists();
        if($user_exists)
            return ['status'=>0,'msg'=>'user is a valid user'];
//         * -encrypted password

//         * Otherwise put the user into the database.
        $hashed_password=Hash::make($password);
//        dd($hashed_password);
        $user=$this;
        $user->password=$hashed_password;
        $user->username=$username;
        $user->avatar_url='null';
        if ($user->save()){
            return ['status'=>1,'id'=>$user->id];
        }else{
            return ['status'=>0,'msg'=>'db insert failed'];
        }
//        dd(Request::get('age'));
//        dd(Request::has('username'));
//        dd(Request::all());
        return 1;
    }

    //Login api
    public function login(){
        //Check user name and password are not null.
        $has_user_name_and_password=$this->has_user_name_and_password();
        if(!$has_user_name_and_password)
            return ['status'=>0,'msg'=>'user name and password can not be null.'];
        $username=$has_user_name_and_password[0];
        $password=$has_user_name_and_password[1];

        //check username and password
        $user=$this->where('username',$username)->first();
        if(!$user)
            return ['status'=>0,'msg'=>'The user does not exist.'];

        $hashed_password=$user->password;

        if (!Hash::check($password,$hashed_password))
            return ['status'=>0,'msg'=>'wrong password'];

//        Write current username and id into session.
        session()->put('username',$user->username);
        session()->put('user_id',$user->id);
//        dd(session()->all());
        return ['status'=>1, 'id'=>$user->id];
    }
}
