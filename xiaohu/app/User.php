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
        return suc();
    }

    //gain the info of a user
    public function read()
    {
        if (!rq('id'))
            return err('no id');
        $get = ['id', 'username', 'avatar_url', 'intro'];

        $user = $this->find(rq('id'),$get);
        $data=$user->toArray();
        $answer_count=answer_ins()->where('user_id',rq('id'))->count();
        $question_count=question_ins()->where('user_id',rq('id'))->count();
        $data['answer_count']=$answer_count;
        $data['question_count']=$question_count;


        return suc($data);
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

    //Log out a user

    /**
     * @return status is 1
     */
    public function log_out(){
//        session()->flush ();
        //delete username and userid from session
//        dd('User logout');
        session()->forget('username');
        session()->forget('user_id');
//        dd(session()->all());
        redirect('/');
        return ['status'=>1];
//        return redirect('/');
//        dd(session()->all());
    }

    //Check a user has loged in or not.
     public function is_log_in(){
        return is_log_in();
     }

     //Change password
    public function change_password(){
        if(!$this->is_log_in()) {
            return ['status' => 1, 'msg' => 'not login.'];
        }

        if(!rq('old_password')||!rq('new_password'))
            return ['status'=>0, 'msg'=>'no old or new password.'];

        $user = $this->find(session('user_id'));
//        dd($user->all());

        if (!Hash::check(rq('old_password'),$user->password))
            return ['status'=>0,'msg'=>'incorrect old password.'];

        $user->password = bcrypt(rq('new_password'));
        return $user->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'save new passowrd to db failed.'];
    }



    //Reset password
    public function reset_password(){

        //use phone to reset password.
        if (rq('phone')){
            return err('phone is missed.');
        }

        //Check has phone info or not
        $exists_phone=$this->where('phone',rq('phone'))->exists();

        if(!$exists_phone)
            return err('no phone info in database');

        return 'reset password';
    }

    //Connect users and   answers table, many to many .
    public function answers(){
        return $this
            ->belongsToMany('App\Answer')
            ->withPivot('vote')
            ->withTimestamps();
    }

    public function questions(){
        return $this
            ->belongsToMany('App\Question')
            ->withPivot('vote')
            ->withTimestamps();
    }

    public function exist()
    {
        return suc(['count'=>$this->where(rq())->count()]);
    }
}
