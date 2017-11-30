<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

function paginate($page=1,$limit=16){
    $limit=$limit?:16;
    $skip=($page?($page-1):0)*$limit;
    return [$limit,$skip];
}

function err($msg=[]){
    return ['status'=>0,'msg'=>$msg];
}

function suc($data_to_merge=[]){
    $data=['status'=>1,'data'=>[]];
    if($data_to_merge)
        $data=array_merge($data['data'],$data_to_merge);
    return $data;
}

function rq($key=null,$default=null){
    if (!$key) return Request::all();
    return Request::get($key,$default);
}

function user_ins()
{
    $user = new App\User;
    return $user;
}
Route::get('/', function () {
    return view('index');
});
Route::any('api',function (){
    return ['version'=>0.1] ;
});

Route::any('api/signUp',function (){
    /**
     * @return \App\User
     */
    return user_ins()->signUp() ;
});

Route::any('api/login',function (){
    return user_ins()->login();
});

Route::any('api/logout',function (){
    return user_ins()->log_out();
});

Route::any('api/user/change_password',function (){
    return user_ins()->change_password();
});

Route::any('api/user/exist',function (){
    return user_ins()->exist();
});

Route::any('api/user/reset_password',function (){
    return user_ins()->reset_password();
});

Route::any('api/user/read',function (){
    return user_ins()->read();
});

function question_ins(){
    return new App\Question;
}

Route::any('api/question/add',function(){
    return question_ins()->add();
});

Route::any('api/question/change',function(){
    return question_ins()->change();
});

Route::any('api/question/read',function(){
    return question_ins()->read();
});

Route::any('api/question/remove',function(){
    return question_ins()->remove();
});

function answer_ins(){
    return new App\Answer;
}
Route::any('api/answer/add',function (){
   return answer_ins()->add();
});

Route::any('api/answer/change',function (){
    return answer_ins()->change();
});

Route::any('api/answer/read',function (){
    return answer_ins()->read();
});

Route::any('api/answer/vote',function (){
    return answer_ins()->vote();
});

function comment_ins(){
    return new App\Comment;
}

Route::any('api/comment/add',function (){
   return comment_ins()->add();
});

Route::any('api/comment/read',function (){
    return comment_ins()->read();
});

Route::any('api/comment/remove',function (){
    return comment_ins()->remove();
});

Route::any('api/timeline','CommonController@timeline');
