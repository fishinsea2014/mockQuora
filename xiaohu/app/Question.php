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
        //If not login, tips login
        if (!user_ins()->is_log_in()){
            return ['status'=>0,'msg'=>'please login. '];
        }

        //If no id, tips id.
        if(!rq('id'))
            return ['status'=>0,'msg'=>'id is required. '];

        //Get module of the current id.
        $question=$this->find(rq('id'));

        //If no questions ,tips.
        if(!$question)
            return ['status'=>0,'msg'=>'question not exists.'];

        //
        if ($question->user_id !== session('user_id')){
            return ['status'=>0,'msg'=>'permission denied'];
        }

        if(rq('title'))
            $question->title=rq('title');

        if(rq('desc'))
            $question->desc=rq('desc');


        return $question->save() ?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db update failed'];
    }
}
