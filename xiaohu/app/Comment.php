<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function add(){

       //Check login or not
        if (!user_ins()->is_log_in())
            return ['status'=>0,'msg'=>'login required'];
        // Check has content or not
        if(!rq('content'))
            return ['status'=>0,'msg'=>'empty content'];
        //Check has question id and answer id or not
        if(!rq('question_id')&&!rq('answer_id'))
            return['status'=>0,'msg'=>'question id and answer id are empty' ];

        //Can not has both question id and answer id.
        if(rq('question_id' )&&rq('answer_id'))
            return ['status'=>0,'msg'=>'can only comment a question or a answer'];

        //Check qeustion exist or not
        if(rq('question_id')){
            $question=question_ins()->find(rq('question_id'));
            if(!$question) return ['status'=>0,'msg'=>'question not exists'];
            $this->question_id=rq('question_id');
        }else{
            $answer=answer_ins()->find(rq('answer_id'));
        }

        //Comment a comment
        if (rq('reply_to')){
            $target=$this->find(rq('reply_to'));
            if (!$target)
                return ['status'=>0,'msg'=>'target comment not exists'];
            //Can not reply to your self.
            if($target->user_id==session('user_id'))
                return ['status'=>0,'cannt reply yourself.'];
            $this->reply_to=rq('reply_to');
        }

        $this->content =rq('content');
        $this->user_id=session('user_id');
        $this->answer_id=rq('answer_id');
        return $this->save()?
            ['status'=>1,'id'=>$this->id]:
            ['status'=>0,'msg'=>'db insert failed'];
    }

    public function read(){
        //Check has question id and answer id or not
        if(!rq('question_id')&&!rq('answer_id'))
            return['status'=>0,'msg'=>'question id and answer id are empty' ];

        if (rq('question_id' )){
            $answer = question_ins()->find(rq('question_id'));
            if (!$answer)
                return ['status'=>0,'msg'=>'Quesiotn does not exist.'];
            $data=$this->where('question_id',rq('question_id'))->get();
        }else{
            $answer=answer_ins()->find(rq('answer_id'));
            dd($answer);
            if (!$answer)
                return ['status'=>0,'msg'=>'the answer can not be found'];
            $data=$this->where('answer_id',rq('answer_id'))->get();
        }

        return ['status'=>1,'data'=>$data->keyBy('id')];
    }

    public function remove(){
        if(!user_ins()->is_log_in())
            return ['status'=>0,'msg'=>'user did not login'];

        if(!rq('id'))
            return ['statud'=>0,'msg'=>'no comment id provided'];

        $comment=$this->find(rq('id'));
        if (!$comment)
            return ['status'=>0,'msg'=>'comment not exist'];
        if(!$comment->user_id==session('user_id'))
            return ['status'=>0,'msg'=>'user is not the writer of the comment'];

        $this->where('reply_to',rq('id'))->delete();
        return $comment->delete()?
            ['status'=>1]:
            ['status'=>0,'comment delete failed'];
    }
}
