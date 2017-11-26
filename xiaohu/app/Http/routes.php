<?php
/**
 * Created by IntelliJ IDEA.
 * User: QSG
 * Date: 26/11/2017
 * Time: 11:10 AM
 */
Route::get('/',function (){
   return view ('welcome');
});
Route::get('api',function (){
   return ['version'=>0.1] ;
});

