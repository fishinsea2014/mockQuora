<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    //
    public function timeline(){
        list($limit,$skip)=paginate(rq('page'),rq('limit'));
        //Get question data
        $question=question_ins()
            ->limit($limit)
            ->skip($skip)
            ->orderBy('created_at','desc')
            ->get();

        //Get answer data
        $answers=answer_ins()
            ->limit($limit)
            ->skip($skip)
            ->orderBy('created_at','desc')
            ->get();
//        dd($question);
//        dd($answers);
        //Combine question data and answer data
        $data=$question->merge($answers);
        $data=$data->sortByDesc(function($item){
            return $item->created_at;
        });

        //Eliminate the key of id.
        $data=$data->values()->all();

        return ['status'=>1,'data'=>$data];
    }
}
