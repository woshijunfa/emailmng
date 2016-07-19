<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Pici;
use App\Models\Email;
use App\Models\PiciLog;
use Auth;
use Input;
use DB;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$contents = Content::where('is_valid','1')->get();
    	$contents = count($contents) > 0 ? $contents : [];

        $picis = Pici::get();
        $picis = count($picis) >0 ? $picis : [];

        return view('email.index',compact('contents','picis'));
    }


    public function addpici()
    {
        $pici = Input::get('pici');
        $contentId = Input::get('contentid');

        $content = Content::where('id',$contentId)->first();
        if (empty($content)) return $this->json(1,"","发送内容不存在");

        $count = Email::where('pici',$pici)->where('is_valid','1')->count();
        PiciLog::insertLog('',['pici'=>$pici,
            'title'=>$content->title,
            'content_id'=>$contentId,
            'total_count'=>$count]);

        return $this->json(0);
    }


    //发送日志
    public function sendlog()
    {
        $pici = Input::get('pici');
        $contentId = Input::get('content_id');

        $logs = PiciLog::orderBy('id','desc');
        if (!empty($pici)) $logs = $logs->where("pici",$pici);
        if (!empty($contentId)) $logs = $logs->where("content_id",$contentId);

        $logs = $logs->take(100)->get();
        $logs = count($logs) > 0 ? $logs : [];


        return view("email.sendlog",compact('logs'));
    }

    //将数据推送到发送队列中
    public function beginSend()
    {
        $id = Input::get("id");
        if (empty($id)) return $this->json(-1,'','参数错误');

        PiciLog::where("id",$id)->where("status",'init')->update(['status'=>'sending']);
        PiciLog::where("id",$id)->whereNull("send_time")->update(['send_time'=>date("Y-m-d H:i:s")]);
        return $this->json(0);
    }

    //清空发送队列
    public function endSend()
    {
        $id = Input::get("id");
        if (empty($id)) return $this->json(-1,'','参数错误');

        PiciLog::where("id",$id)->where("status",'sending')->update(['status'=>'init']);
        return $this->json(0);
    }
}
