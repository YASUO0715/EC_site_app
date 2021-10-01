<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{


    public function showServiceProviderTest()
    {
        $encrypt = app()->make('encrypter');
        $password = $encrypt->encrypt('password');

        $sample = app()->make('serviceProviderTest');

        dd($sample,$password,$encrypt->decrypt($password));
    }
    public function showServiceContainerTest()
    {
        app()->bind('lifeCycleTest',function(){
            return 'ライフサイクルテスト';
        });
        $test = app()->make('lifeCycleTest');

        //サービスコンテナ無しのパターン。それぞれのクラスをいちいちインスタンス化してあげれば使える。
        // $message = new Message();
        // $sample = new Sample($message);
        // $sample->run();

        //サービスコンテナありのパターン. newをしなくてもインスタンス化できる。
        //app()->make だけで依存関係を解決して簡単に使用できる。
        app()->bind('sample',Sample::class);
        $sample = app()->make('sample');
        $sample -> run();

        dd($test,app());
    }
}

class sample
{
    public $message;            
    //引数にクラスを入れてあげると、自動的にインスタンス化する。
    public function __construct(Message $message){
        $this->message = $message;
}
    public function run(){
        $this->message->send();
}
}

class Message 
{
    public  function send()
    {
        echo ('メッセージを表示');
    }

}
