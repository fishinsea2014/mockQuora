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
        if (!user_ins()->is_logged_in()){
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
        if (!user_ins()->is_logged_in()){
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

    /*
     * Read  questions
     */
    public function read(){
        //If request has id, then return No.id question
        if (rq('id'))
            return ['status'=>1,'data'=>$this->find(rq('id'))];

        //If no id in quest, return a number of questions according to the limit of a page
//        $page_items_limit=rq('limit')?:15;
//        $skip=(rq('page')?(rq('page')-1):0)*$page_items_limit;

        //limit is how many items in a page, skip is used to paginate.
        list($limit,$skip)=pageinate(rq('page'),rq('limit'));

        $r=$this
            ->orderBy('created_at')
            ->limit($limit)
            ->skip($skip)
            ->get(['id','title','desc','user_id','created_at','updated_at'])
            ->keyBy('id');


        return ['status'=>1,'data'=>$r];
    }

    /*
     * Remove a question
     */
    public function remove(){
        //If not login, tips login
        if (!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'please login. '];
        }

        //If no id, tips id.
        if(!rq('id'))
            return ['status'=>0,'msg'=>'id is required. '];

        $question= $this->find(rq('id'));
        if (!$question) return ['status'=>0, 'msg'=>'question dose not exist'];

        //Check question user id by the session id, denied when not consistent.
        if (session('user_id')!=$question->user_id)
            return ['status'=>0, 'msg'=>'permission denied.'];

        return $question->delete()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db delete failed.'];
    }
}
