<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**Add a question
     *
    **/
    public function add(){
        //If not login, tips login
        if (!user_ins()->is_log_in()){
            return ['status'=>0,'msg'=>'please login. '];
        }

        //If no title, tips input title
        if(!rq('title')){
            return ['status'=>0,'msg'=>'please input title'];
        }

        //Insert current question into table question.
        $this->title=rq('title');
        $this->user_id=session('user_id');
        if (rq('desc'))
            $this->desc=rq('desc');

        return $this->save() ?
            ['status'=>1,'id'=>$this->id]:
            ['status'=>0,'msg'=>'db insert failed'];

    }

    /*Change a question
    */
    public function change(){
        return 1;
    }
}
