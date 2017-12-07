<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //Manipulate answers options

    public function add(){
        //If not login, tips login
        if (!user_ins()->is_log_in()){
            return ['status'=>0,'msg'=>'please login. '];
        }

        if (!rq('question_id')||!rq('content'))
            return  ['status'=>0,'msg'=>'question id and conent ara both required.'];

        //Check the question exists or not
        $question=question_ins()->find(rq('question_id'));
        if (!$question) return ['status'=>0,'msg'=>'question not exists'];

        //Check the question has been answered.
        //where(['key'=>'value',...])
        $answered=$this
            ->where(['question_id'=>rq('question_id'),'user_id'=>session('user_id')])
            ->count();
        if ($answered)
            return ['status'=>0,'msg'=>'duplicated answer'];

        //Save the answer.
        $this->content=rq('content');
        $this->question_id=rq('question_id');
        $this->user_id=session('user_id');

        return $this->save()?
            ['status'=>1,'id'=>$this->id]:
            ['status'=>0,'msg'=>'db insert failed.'];

//        return 'answer';
    }

    //update an answer
    public function change(){
        //Update an answer

        //If not login, tips login
        if (!user_ins()->is_log_in()){
            return ['status'=>0,'msg'=>'please login. '];
        }

        if (!rq('id')||!rq('content'))
            return  ['status'=>0,'msg'=>'answer id and conent ara both required.'];

        $answer=$this->find(rq('id'));
        if($answer->user_id != session('user_id'))
            return ['status'=>0, 'msg'=>'not the author of the answer'];

        $answer->content=rq('content');
        return $answer->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db update failed'];
    }

    //View the answers
    public function read(){

        //Check answer id and question id exist or not.
        if(!rq('id')&& !rq('question_id'))
            return ['status'=>0,'msg'=>'id or question_id is required'];

        //Get an answer
        if(rq('id')){
            $answer= $this->find(rq('id'));
            if(!$answer)
                return ['status'=>0,'msg'=>'answer does not exist'];
            return ['status'=>1,'data'=>$answer];
        }
        //Check the question exist or not.
        if (!question_ins()->find(rq('question_id')))
            return ['status'=>0,'msg'=>'question does not exist'];
        //Get the answers for a question.
        $answers=$this
            ->where('question_id',rq('question_id'))
            ->get()
            ->keyBy('id');

        return ['status'=>1,'data'=>$answers];
    }

    //Vote API
    public function vote(){
        if(!user_ins()->is_log_in())
            return ['stauts'=>0,'msg'=>'not log in'];

        if(!rq('id')||!rq('vote'))
            return ['status'=>0,'msg'=>'id and vote, up or down, is null'];

        $answer=$this->find(rq('id'));
        if(!$answer)
            return ['status'=>0,'msg'=>'the answer does not exist'];

        //1 up,2 down
        $vote=rq('vote')<=1 ? 1:2;

        //Check whether the user vote to same answer, if has been voted, delete previous vote.
        $answer
            ->users()
            ->newPivotStatement()
            ->where('user_id',session('user_id'))
            ->where('answer_id',rq('id'))
            ->delete();

        $answer->users()->attach(session('user_id'),['vote'=>$vote]);

        return['status'=>1];




    }

    //Connect the user who answer a question.
    public function user(){
        return $this->belongsTo('App\User');
    }

    //Connect users who vote the question and   answers table, many to many .
    public function users(){
        return $this
            ->belongsToMany('App\User')
            ->withPivot('vote')
            ->withTimestamps();
    }

}
